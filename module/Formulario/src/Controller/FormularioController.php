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

        //Actualmente mostrará todas las tareas creadas sin filtro alguno
        $arrTareasJSON = $this->catalogoManager->getArrEntidadJSON('Tareas');

        return new ViewModel([
            "OperacionesJSON" => $OperacionesJSON,
            'arrTareasJSON' => $arrTareasJSON
        ]);
    }

    public function cargarAction(){
        $this->cargarAccionesDisponibles('formularios - cargar');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - cargar');
        
        $parametros = $this->params()->fromRoute();
        $idTarea = $parametros['id'];
        $Tarea = $this->catalogoManager->getTareas($idTarea);

        if ($this->getRequest()->isPost()) {
            $JsonData = $this->params()->fromPost();
            $data = json_decode($JsonData['JsonData']);
            $this->FormularioManager->altaRespuestasFormulario($data, $idTarea);
            $this->redirect()->toRoute("formulario",["action" => "index"]);
        }

        $Formulario = $Tarea->getRelevamiento()->getFormulario();
        
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
        // $idTarea = $parametros['id'];
        // $Tarea = $this->catalogoManager->getTareas($idTarea);
        $idRelevamiento = $parametros['id'];
        $Relevamiento = $this->catalogoManager->getRelevamientos($idRelevamiento);
        // $Formulario = $Relevamiento->getFormulario();
        $data = $this->FormularioManager->getRespuestas($Relevamiento);
        // var_dump($data);

        // $data = $this->params()->fromRoute();
        // $idManifiesto = $data['id'];

        $view = new ViewModel();

        // $empresa = $this->getDatosEmpresa();
        // $Manifiesto = $this->catalogoManager->getManifiestoPorId($idManifiesto);
        // $data = $this->manifiestosManager->getDataPDF($Manifiesto);

        $renderer = $this->renderer;
        $view->setTemplate('layout/pdfFormulario');
        $view->setVariable('data', $data);

        $html = $renderer->render($view);

        $pdf = $this->tcpdf;

        $pdf->SetFont('arialnarrow', '', 8, '', false);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 70, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));

        $pdf->SetFont('helvetica', 'BI', 18);
        $pdf->Cell(0, 5, $data['descripcionFormulario'], 0, 1, 'C');
        $pdf->Ln(10);

        // $pdf->SetFont('helvetica', '', 12);
        foreach ($data['secciones'] as $seccion) {
            $pdf->SetFont('helvetica', '', 16);
            $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
            $pdf->Ln(20);
            $respuestas = $seccion['respuestas'];
            foreach ( $respuestas as $respuesta) { 
                $pregunta = $respuesta['pregunta'];
                $pdf->SetFont('helvetica', '', 12);
                $descripcion = $pregunta['descripcion']; 
                // var_dump($descripcion);
                if($descripcion == '') { $descripcion = ' ';}
                $pdf->Cell(35, 5,  $descripcion);
                // $pdf->TextField($pregunta['descripcion'], 50, 5);
                $pdf->TextField( $descripcion, 60, 5, array(), array('v'=>$respuesta['respuesta'], 'dv'=>$respuesta['respuesta']));
                $pdf->Ln(10);

                
                
            }

        }

        $pdf->Output();
    }

    
}
