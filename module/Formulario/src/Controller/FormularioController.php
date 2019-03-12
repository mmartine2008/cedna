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

            $this->redirect()->toRoute("formularios", ["action" => "asignacion"]);
        }

        $arrFormulariosJSON = $this->catalogoManager->getArrEntidadJSON('Formularios');
        $Tareas = $Planificacion->getTarea();

        $view = new ViewModel();
        
        $view->setVariable('PlanificacionJSON', $Planificacion->getJSON());
        $view->setVariable('TareaJSON', $Tareas->getJSON());
        $view->setVariable('arrFormulariosJSON', $arrFormulariosJSON);
        $view->setTemplate('formulario/formulario/asignar-formulario.phtml');
        
        return $view;
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

        $Formulario = $Planificacion->getRelevamiento()->getFormulario();
        
        return new ViewModel([
            "formulario" => $this->FormularioManager->getJSONActualizado($Formulario),
            "OperacionesJSON" => $OperacionesJSON,
        ]);
    }

    public function showFormAction() {
        $idFormulario = 1;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $JsonData = $this->params()->fromPost();
            $data = json_decode($JsonData['JsonData']);
            $this->FormularioManager->altaRespuestasFormulario($data);
        }
        return new ViewModel([ ]);
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
            $pdf->SetFont('helvetica', '', 16);
            $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
            $pdf->Ln(20);
            $respuestas = $seccion['respuestas'];

            foreach ( $respuestas as $respuesta) { 
                $pregunta = $respuesta['pregunta'];
                $pdf->SetFont('helvetica', '', 12);
                $descripcion = $pregunta['descripcion']; 
                if($descripcion == '') { $descripcion = ' ';}

                if(!$respuesta['destino'] == '') { $descripcion = $respuesta['destino'] ;}


                $pdf->Cell(35, 5,  $descripcion);
                $pdf->TextField( $descripcion, 100, 5, array(), array('v'=>$respuesta['respuesta'], 'dv'=>$respuesta['respuesta']));
                $pdf->Ln(10);
            }

            // $pdf->Cell(35, 5, 'List:');
            // $pdf->ListBox('listbox', 60, 15, array('', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'item7'), array('multipleSelection'=>'true'));
            // $pdf->Ln(20);

        }

        $pdf->Output();
    }

    
}
