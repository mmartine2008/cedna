<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class FormularioController extends CednaController
{
    
    /*
     * @var \TCPDF
    */  
    protected $tcpdf;
    /**
     * @var RendererInterface
     */
    protected $renderer;

    private $FormularioManager;


    public function __construct($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer) {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->FormularioManager = $FormularioManager;
        $this->tcpdf = $tcpdf;
        $this->renderer = $renderer;
    }

    public function indexAction() {
        $this->cargarAccionesDisponibles('formularios');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios');

        return new ViewModel([
            "OperacionesJSON" => $OperacionesJSON
        ]);
    }

    public function paraCargarAction() {
        $this->cargarAccionesDisponibles('formularios - para cargar');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - para cargar');

        //Actualmente mostrará todas las planificaciones de todas las tareas creadas sin filtro alguno
        $arrTareasJSON = $this->catalogoManager->getArrEntidadJSON('Tareas');

        return new ViewModel([
            "OperacionesJSON" => $OperacionesJSON,
            'arrTareasJSON' => $arrTareasJSON
        ]);
    }

    /**
     * Accion para listar las planificaciones para poder asignarle/modificarle
     * un formulario o permiso de trabajo.
     *
     * @return ViewModel
     */
    public function asignacionAction(){
        $this->cargarAccionesDisponibles('formularios - asignacion');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - asignacion');

        $arrTareasJSON = $this->catalogoManager->getArrEntidadJSON('Tareas');

        return new ViewModel([
            "OperacionesJSON" => $OperacionesJSON,
            'arrTareasJSON' => $arrTareasJSON
        ]);
    }

    /**
     * Accion para asignarle a la planificacion un formulario especifico.
     *
     * @return ViewModel
     */
    public function asignarAction(){
        $this->cargarAccionesDisponibles('formularios - asignar');

        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->FormularioManager->asignarFormularioAPlanificacion($JsonData, $Planificacion);

            $this->redirect()->toRoute("formulario", ["action" => "asignacion"]);
        }

        $arrFormulariosJSON = $this->catalogoManager->getArrEntidadJSON('Formulario');
        $Tareas = $Planificacion->getTarea();

        $view = new ViewModel();
        
        $view->setVariable('PlanificacionJSON', $Planificacion->getJSON());
        $view->setVariable('TareaJSON', $Tareas->getJSON());
        $view->setVariable('arrFormulariosJSON', $arrFormulariosJSON);
        $view->setTemplate('formulario/formulario/asignar-formulario.phtml');
        
        return $view;
    }

    private function getDestinos(){
        $destinos = ['Disponible', 'Seleccionados', 'No seleccionados'];
        return $destinos;
    }

    public function cargarAction(){
        $this->cargarAccionesDisponibles('formularios - cargar');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - cargar');
        
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);

        if ($this->getRequest()->isPost()) {
            $JsonData = $this->params()->fromPost();
            $data = json_decode($JsonData['JsonData']);
            $this->FormularioManager->altaRespuestasFormulario($data, $idPlanificacion);
            $this->redirect()->toRoute("formulario",["action" => "index"]);
        }

        $Relevamiento = $Planificacion->getRelevamiento();
        $Formulario = $Relevamiento->getFormulario();
        $destinos = $this->getDestinos();
        $FormularioJSON = $this->FormularioManager->getJSONActualizado($Formulario, $Relevamiento);
        
        return new ViewModel([
            "formulario" => $FormularioJSON,
            "OperacionesJSON" => $OperacionesJSON,
            "destinos" => $destinos
        ]);
    }

    /**
     * Funcion que cambia el estado de un permiso de trabajo para ser firmado
     *
     * @return void
     */
    public function paraFirmarAction(){
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];

        $this->FormularioManager->colocarRelevamientoParaFimar($idPlanificacion);

        $this->redirect()->toRoute("formulario", ["action" => "paraCargar"]);
    }

    private function getListaRespuestas($respuestas) {
        $output = [];
        foreach($respuestas as $respuesta) {
            $output[] = $respuesta['respuesta'];
        }
        return $output;
    }

    private function imprimirSelectoresMultiples($respuesta, $pdf) {
        $respuestas = $respuesta['respuesta'];
        foreach($respuestas as $resp) {
            $pdf->SetFont('helvetica', 'B', 12);
            $list = $this->getListaRespuestas($resp['respuestas']);
            $destino = substr($resp['destino'], 8, 1);
            $listaDestinos = $this->getDestinos();
            $pdf->Cell(40, 5, $listaDestinos[$destino]);
            $pdf->Ln(12);
            foreach ($list as $valor) {
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(25, 5, "");
                $pdf->Cell(100, 5,  $valor);
                $pdf->Ln(10);
            }
        }
    }

    private function imprimirPregunta($respuesta, $pdf, $descripcion){
        $pdf->Cell(50, 5,  $descripcion);
        $pdf->SetFont('helvetica', '', 12);
        $resp = $respuesta['respuesta'];
        $pdf->Cell(45, 5, $resp['respuesta']);
        $pdf->Ln(10);
    }

    private function imprimirPreguntas($respuestas, $pdf){
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                $pdf->SetFont('helvetica', 'B', 12);
                $descripcion = $respuesta['descripcionPregunta'];
                if($descripcion == '') { $descripcion = ' ';}
                if(! $respuesta['poseeDestinos']) {
                    $this->imprimirPregunta($respuesta, $pdf, $descripcion);
                } else {
                    $this->imprimirSelectoresMultiples($respuesta, $pdf);
                }
            }
        }
    }

    private function imprimirFirmas($respuestas, $pdf) {
        $pdf->Ln(20);
        // $pdf->Cell(20, 5,  "");
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                $respuestas = $respuesta['respuesta'];
                foreach($respuestas as $resp) {
                    $pdf->SetFont('helvetica', 'B', 12);
                    $list = $this->getListaRespuestas($resp['respuestas']);
                    $destino = substr($resp['destino'], 8, 1);
                    $listaDestinos = $this->getDestinos();
                    if($listaDestinos[$destino] == "Seleccionados") {
                        // for($i = 0; $i < count($list); $i++){
                        $i = 0;
                        $cantFirmas = count($list);
                        $modulo = $cantFirmas%3;
                        $pdf->SetFont('helvetica', '', 12);
                        while($i < count($list)){
                            if($i+3 >= count($list)) {
                                if($modulo == 2) {
                                    $pdf->Cell(40, 5,  "");
                                    $pdf->Cell(60, 5,  $list[$i]);
                                    $pdf->Cell(60, 5,  $list[$i+1]);
                                } else {
                                    $pdf->Cell(80, 5,  "");
                                    $pdf->Cell(60, 5,  $list[$i]);
                                }
                            } else {
                                $pdf->Cell(20, 5,  "");
                                $pdf->Cell(60, 5,  $list[$i]);
                                $pdf->Cell(60, 5,  $list[$i+1]);
                                $pdf->Cell(60, 5,  $list[$i+2]);
                            }
                            $pdf->Ln(30);
                            $i = $i+3;
                        }    
                    }
                }
            }
        }
    }


    private function imprimirSecciones($pdf, $seccion){
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 16);
        $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
        $pdf->Ln(18);
        $respuestas = $seccion['respuestas'];
        if($seccion['descripcionSeccion'] == "Firmas del Permiso") {
            $this->imprimirFirmas($respuestas, $pdf);
        } else {
            $this->imprimirPreguntas($respuestas, $pdf);
        }
    }

    public function imprimirAction() {

        $parametros = $this->params()->fromRoute();
        $idRelevamiento = $parametros['id'];
        $Relevamiento = $this->catalogoManager->getRelevamientos($idRelevamiento);
        $data = $this->FormularioManager->getRespuestas($Relevamiento);
        
        $view = new ViewModel();

        $renderer = $this->renderer;
        $view->setTemplate('layout/pdfFormulario');
        $view->setVariable('data', $data);

        $html = $renderer->render($view);

        $pdf = $this->tcpdf;

        $pdf->SetFont('arialnarrow', '', 8, '', false);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));

        $pdf->SetFont('helvetica', 'BI', 18);
        $pdf->Cell(0, 5, $data['descripcionFormulario'], 0, 1, 'C');
        $pdf->Ln(10);

        foreach ($data['secciones'] as $seccion) {
            $this->imprimirSecciones($pdf, $seccion);
        }
        $pdf->Output();
    }

    public function formulariosParaFirmarAction(){
        $this->cargarAccionesDisponibles('formularios - para firmar');

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);
    
        $arrTareasJSON = $this->FormularioManager->getArrTareasJSONFormulariosAFirmar($UsuarioActivo);
    
        return new ViewModel([
            'arrTareasJSON' => $arrTareasJSON,
            'UsuarioActivoJSON' => $UsuarioActivo->getJSON()
        ]);
    }

    public function firmarFormularioAction(){
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);
        $this->FormularioManager->firmarFormulario($idPlanificacion, $UsuarioActivo);

        $this->redirect()->toRoute("formulario", ["action" => "formulariosParaFirmar"]);
    }

    public function delegarFirmaAction(){
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);
        $this->FormularioManager->delegarFirmaFormulario($idPlanificacion, $UsuarioActivo);

        $this->redirect()->toRoute("formulario", ["action" => "formulariosParaFirmar"]);
    }

    public function puedeDelegarAction(){
        $parametros = $this->params()->fromRoute();
        $idNodo = $parametros['id'];

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        $resultado = $this->FormularioManager->comprobarUsuarioPuedeDelegar($idNodo, $UsuarioActivo);

        $view = new ViewModel();
        
        $view->setVariable('mostrarJson', json_encode(['resultado' => $resultado]));
        $view->setTerminal(true);
        $view->setTemplate('formulario/formulario/mostrarJSON.phtml');
        
        return $view;
    }
    
}
