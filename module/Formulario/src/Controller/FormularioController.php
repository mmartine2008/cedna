<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Formulario\Controller\BaseFormularioController;
use Zend\View\Model\ViewModel;

class FormularioController extends BaseFormularioController
{
    public function __construct($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer) {
        parent::__construct($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer);
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

    function mostrarImagenAction(){
        $datos_archivo = $this->FormularioManager->getPathFiles();

        $id = $this->params()->fromRoute('id');
        $nombreArchivo = $this->FormularioManager->getRespuesta($id)->getNombreArchivo();
            
        $name = $datos_archivo['path']."/".$nombreArchivo;
        $img = file_get_contents($name);

        header('Content-type:image/png');

        echo ($img);
    }

    public function cargarAction(){
        $this->cargarAccionesDisponibles('formularios - cargar');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - cargar');
        
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();

        if ($this->getRequest()->isPost()) {
            $params = $this->params()->fromPost();
            $data = json_decode($params['JsonData']);
            $listaArchivos = json_decode($params['archivos']);
            $archivo = (isset($_FILES["archivo"])) ? $_FILES["archivo"] : null;

            $this->FormularioManager->altaRespuestasYArchivosFormulario($Planificacion, $data, $listaArchivos, $archivo);

            $this->redirect()->toRoute("formulario",["action" => "index"]);
        }
        $Formulario = $Relevamiento->getFormulario();
        $FormularioJSON = $this->FormularioManager->getJSONActualizado($Formulario, $Relevamiento);
        return new ViewModel([
            "formulario" => $FormularioJSON,
            "OperacionesJSON" => $OperacionesJSON,
            "destinos" => $this->getDestinos(),
            "idRelevamiento" => $Relevamiento->getId(),
            "enEdicion" => $Relevamiento->getEstadoRelevamiento()->esEditado(),
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

    public function imprimirAction() {
        $datos_empresa = $this->FormularioManager->getDatosEmpresa();
        $fecha_hoy = date("d/m/Y  H:i:s");
        $fecha_emision = date("d/m/Y");
        $titulo = $datos_empresa['name'];
        $logo = $datos_empresa['logo'];

        $parametros = $this->params()->fromRoute();
        $idRelevamiento = $parametros['id'];
        $Relevamiento = $this->catalogoManager->getRelevamientos($idRelevamiento);
        $data = $this->FormularioManager->getRespuestas($Relevamiento);
        $nombreUsuario = $this->catalogoManager->getUsuarioPorRelevamiento($idRelevamiento);
        
        $view = new ViewModel();

        $renderer = $this->renderer;
        $view->setTemplate('layout/pdfFormulario');
        $view->setVariable('data', $data);

        $html = $renderer->render($view);

        $pdf = $this->tcpdf;

        $pdf->SetFont('helvetica', '', 8, '', false);

        $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->setTitulo($titulo);
        $pdf->setFechaEmision($fecha_emision);
        $pdf->setLogo($logo);
        
        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));
        $pdf->SetFont('helvetica', 'BI', 14);
        $pdf->Cell(0, 5, $data['descripcionFormulario'], 0, 1, 'L');
        $pdf->Ln(5);

        foreach ($data['secciones'] as $seccion) {
            $this->imprimirSecciones($pdf, $seccion);
        }

        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 5, "Emitido por ".$nombreUsuario." - Cedna Software - ".$fecha_hoy, 0, 1, 'R');

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

        $arrTareasJSON = $this->FormularioManager->getArrTareasJSONFormulariosAFirmar($UsuarioActivo);
        $view = new ViewModel();
        
        $view->setVariable('mostrarJson', json_encode(['arrTareasJSON' => $arrTareasJSON]));
        $view->setTerminal(true);
        $view->setTemplate('formulario/formulario/mostrarJSON.phtml');
        
        return $view;
    }

    public function delegarFirmaAction(){
        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);
        $mensaje = $this->FormularioManager->delegarFirmaFormulario($idPlanificacion, $UsuarioActivo);

        $arrTareasJSON = $this->FormularioManager->getArrTareasJSONFormulariosAFirmar($UsuarioActivo);

        $view = new ViewModel();
        
        $view->setVariable('mostrarJson', json_encode(['mensaje' => $mensaje, 'arrTareasJSON' => $arrTareasJSON]));
        $view->setTerminal(true);
        $view->setTemplate('formulario/formulario/mostrarJSON.phtml');
        
        return $view;
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
