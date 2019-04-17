<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Application\Controller\CednaController;
use function GuzzleHttp\json_decode;

class BaseFormularioController extends CednaController
{
    
    /*
     * @var \TCPDF
    */  
    protected $tcpdf;
    /**
     * @var RendererInterface
     */
    protected $renderer;

    protected $FormularioManager;


    public function __construct($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer) {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->FormularioManager = $FormularioManager;
        $this->tcpdf = $tcpdf;
        $this->renderer = $renderer;
    }

    protected function getDestinos(){
        $destinos = ['Disponible', 'Seleccionados', 'No seleccionados'];
        return $destinos;
    }

    protected function getListaRespuestas($respuestas) {
        $output = [];
        foreach($respuestas as $respuesta) {
            $output[] = $respuesta['respuesta'];
        }
        return $output;
    }

    protected function imprimirSelectoresMultiples($respuesta, $pdf, $color) {
        $respuestas = $respuesta['respuesta'];
        foreach($respuestas as $resp) {
            $pdf->SetFont('helvetica', 'I', 10);
            $list = $this->getListaRespuestas($resp['respuestas']);
            $listaDestinos = $this->getDestinos();
            $pdf->Cell(40, 5, $listaDestinos[1]);
            $pdf->Ln(6);
            foreach ($list as $valor) {
                if($color) {
                    $pdf->SetTextColor(0, 0, 0, 70);
                } else {
                    $pdf->SetTextColor(0, 0, 0, 100);
                }
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(25, 5, "");
                $pdf->Cell(100, 5, "- ".$valor);
                $pdf->Ln(5);
                $color = !$color;
            }
        }
    }

    private function mostrarImagen($nombreArchivo, $pdf, $descripcion, $respuesta) {
        $datos_archivo = $this->FormularioManager->getPathFiles();
        $name = $datos_archivo['path']."/".$nombreArchivo;

        $urlImagen = $name;
        $file_ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $pdf->Cell(50, 5,  $descripcion);
        $pdf->Image($urlImagen, "", "", "30", '', $file_ext, '', '', false, 300, '', false, false, 0, false, false, false);        
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(50);
    }

    protected function imprimirPregunta($respuesta, $pdf, $descripcion, $color){
        if($respuesta['archivo'] == "") {
            $pdf->Cell(50, 5,  $descripcion);
            $pdf->SetFont('helvetica', '', 10);
            $resp = $respuesta['respuesta'];
            if($respuesta['tipoPregunta'] == 'date') {
                $time = strtotime($resp['respuesta']);
                $resp = date('d/m/Y',$time);
            } else {
                $resp = $resp['respuesta'];
            }
            $pdf->Cell(45, 5, $resp);
            $pdf->Ln(6);
        } else {
            $this->mostrarImagen($respuesta['archivo'], $pdf, $descripcion, $respuesta);
        }
        return !$color;
    }

    protected function imprimirPreguntas($respuestas, $pdf, $seccion, $color){
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
        $pdf->Ln(8);
    
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                if($color) {
                    $pdf->SetTextColor(0, 0, 0, 70);
                } else {
                    $pdf->SetTextColor(0, 0, 0, 100);
                }
                $pdf->SetFont('helvetica', 'I', 10);
                $descripcion = $respuesta['descripcionPregunta'];
                if($descripcion == '') { $descripcion = ' ';}
                if($respuesta['tipoPregunta'] == 'multiple') {
                    $color = $this->imprimirSelectoresMultiples($respuesta, $pdf, $color);
                } else {
                    $color = $this->imprimirPregunta($respuesta, $pdf, $descripcion, $color);
                }
            }
        }
        return $color;
    }

    protected function imprimirFirmasSeleccionadas($pdf, $list) {
            $i = 0;
            $cantFirmas = count($list);
            $modulo = $cantFirmas%3;
            $pdf->SetFont('helvetica', '', 10);
            while($i < count($list)){
                if($i+3 >= count($list)) {
                    if($modulo == 2) {
                        $pdf->Cell(30, 5,  "");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Ln(5);

                        $pdf->Cell(40, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                        $pdf->Cell(60, 5,  $list[$i+1]);
                    } else {
                        $pdf->Cell(70, 5,  "");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Ln(5);

                        $pdf->Cell(80, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                    }
                } else {
                    $pdf->Cell(13, 5,  "");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Ln(5);

                    $pdf->Cell(20, 5,  "");
                    $pdf->Cell(60, 5,  $list[$i]);
                    $pdf->Cell(60, 5,  $list[$i+1]);
                    $pdf->Cell(60, 5,  $list[$i+2]);
                }
                $pdf->Ln(25);
                $i = $i+3;
            }    
    }

    protected function imprimirRespuestasFirmas($respuestas, $pdf){
        foreach($respuestas as $resp) {
            $pdf->SetFont('helvetica', 'B', 10);
            $list = $this->getListaRespuestas($resp['respuestas']);
            $this->imprimirFirmasSeleccionadas($pdf, $list);
        }
    }

    protected function imprimirFirmas($respuestas, $pdf, $seccion) {
        $pdf->Ln(10);
        $posicionY = $pdf->GetY();
        $tamanio_pagina = $pdf->getPageHeight() ;

        if ($tamanio_pagina - $posicionY <= 80) { 
            $pdf->AddPage(); 
        }
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
        $pdf->Ln(8);

        $pdf->Ln(20);
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                $respuestas = $respuesta['respuesta'];
                $this->imprimirRespuestasFirmas($respuestas, $pdf);
            }
        }
    }

    protected function imprimirSecciones($pdf, $seccion, $color){
        $pdf->SetTextColor(0, 0, 0, 100);
        $respuestas = $seccion['respuestas'];
        $pdf->Ln(5);
        
        if($seccion['descripcionSeccion'] == "Firmas del Permiso") {
            $this->imprimirFirmas($respuestas, $pdf, $seccion);
        } else {
            $color = $this->imprimirPreguntas($respuestas, $pdf, $seccion, $color);
        }
        return $color;
    }

    protected function imprimirFormulario($pdf, $data) {
        $pdf->setFormDefaultProp(array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 200), 'strokeColor'=>array(255, 128, 128)));
        $pdf->SetFont('helvetica', 'BI', 14);
        $pdf->Cell(0, 5, $data['descripcionFormulario'], 0, 1, 'L');
        $pdf->Ln(5);

        $color = true;
        foreach ($data['secciones'] as $seccion) {
            $color = $this->imprimirSecciones($pdf, $seccion, $color);
        }
    }

    private function imprimirDetallesPlanificacion($pdf, $Planificacion) {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Planificación: ");
        $pdf->Cell(45, 5, $Planificacion->titulo);
        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Observaciones: ");
        $pdf->Cell(45, 5, $Planificacion->observaciones);
        $pdf->Ln(6);


        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Fecha de Inicio: ");
        $time = strtotime($Planificacion->fechaInicio);
        $resp = date('d/m/Y',$time);
        $pdf->Cell(45, 5, $resp);
        $pdf->Ln(6);

        $pdf->Cell(50, 5,  "Fecha de Finalización: ");
        $time = strtotime($Planificacion->fechaFin);
        $resp = date('d/m/Y',$time);
        $pdf->Cell(45, 5, $resp);
        $pdf->Ln(6);

        $pdf->Cell(50, 5,  "Hora de Inicio: ");
        $time = strtotime($Planificacion->horaInicio);
        $resp = date('H:m',$time);
        $pdf->Cell(45, 5, $resp);
        $pdf->Ln(10);
    }

    protected function imprimirInformacionPlanificacion($pdf, $Planificacion) {
        $pdf->SetFont('helvetica', 'BI', 14);
        $pdf->Cell(0, 5, "Detalles de la Planificación", 0, 1, 'L');
        $pdf->Ln(5);
        $this->imprimirDetallesPlanificacion($pdf, $Planificacion);

    }

    private function imprimirDetallesObra($pdf, $Tarea) {
        //ver si poner nodo y si esta bien planificaTarea
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Usuario que planifica la Obra: ");
        $pdf->Cell(45, 5, $Tarea->planificaTarea->nombre);
        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Solicitante: ");
        $pdf->Cell(45, 5, $Tarea->solicitante->nombre);
        $pdf->Ln(6);

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Ejecutor: ");
        $pdf->Cell(45, 5, $Tarea->ejecutor->nombre);
        $pdf->Ln(6);


        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(50, 5,  "Responsable: ");
        $pdf->Cell(45, 5, $Tarea->responsable->nombre);
        $pdf->Ln(6);

        $pdf->Cell(50, 5,  "Descripcion: ");
        $pdf->Cell(45, 5, $Tarea->descripcion);
        $pdf->Ln(6);

        $pdf->Cell(50, 5,  "Tipo de Planificacion: ");
        $pdf->Cell(45, 5, $Tarea->tipoPlanificacion->descripcion);
        $pdf->Ln(10);
    }

    protected function imprimirInformacionTarea($pdf, $Tarea) {
        $pdf->SetFont('helvetica', 'BI', 14);
        $pdf->Cell(0, 5, "Detalles de la Obra", 0, 1, 'L');
        $pdf->Ln(5);
        $this->imprimirDetallesObra($pdf, $Tarea);

    }
    
}