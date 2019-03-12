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

    private function getListaRespuestas($respuestas) {
        $output = [];
        foreach($respuestas as $respuesta) {
            $output[] = $respuesta['respuesta'];
        }
        return $output;
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
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', '', 16);
            $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
            $pdf->Ln(18);
            $respuestas = $seccion['respuestas'];

            foreach ( $respuestas as $respuestaxRespuesta) { 
                foreach ( $respuestaxRespuesta as $respuesta) { 
                //ver como diferenciar las respuestas
                    $pdf->SetFont('helvetica', 'B', 12);
            
                    $descripcion = $respuesta['descripcionPregunta'];
                    if($descripcion == '') { $descripcion = ' ';}

                    // var_dump();
                    // var_dump(($respuesta));
                    if(! $respuesta['poseeDestinos']) {
                        $pdf->Cell(50, 5,  $descripcion);
                        $pdf->SetFont('helvetica', '', 12);
                        $resp = $respuesta['respuesta'];
                        $pdf->Cell(45, 5, $resp['respuesta']);
                        $pdf->Ln(10);
                    } else {
                        $respuestas = $respuesta['respuesta'];
                        // var_dump($respuestas);
                        foreach($respuestas as $resp) {
                            $pdf->SetFont('helvetica', 'B', 12);
                            $list = $this->getListaRespuestas($resp['respuestas']);
                            // $list = [];
                            $pdf->Cell(40, 5, $resp['destino']);
                            $pdf->Ln(12);
                            foreach ($list as $valor) {
                                $pdf->SetFont('helvetica', '', 12);
                                $pdf->Cell(25, 5, "");
                                $pdf->Cell(100, 5,  $valor);
                                $pdf->Ln(10);
                            }
                        }
                    }
                    
                }
            }
        }

        $pdf->Output();
    }

    
}
