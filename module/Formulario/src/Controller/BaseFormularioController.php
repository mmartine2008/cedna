<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Application\Controller\CednaController;

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

    protected function imprimirSelectoresMultiples($respuesta, $pdf) {
        $respuestas = $respuesta['respuesta'];
        foreach($respuestas as $resp) {
            $pdf->SetFont('helvetica', 'I', 10);
            $list = $this->getListaRespuestas($resp['respuestas']);
            $listaDestinos = $this->getDestinos();
            $pdf->Cell(40, 5, $listaDestinos[1]);
            $pdf->Ln(6);
            foreach ($list as $valor) {
                $pdf->SetFont('helvetica', '', 10);
                $pdf->Cell(25, 5, "");
                $pdf->Cell(100, 5, "- ".$valor);
                $pdf->Ln(5);
            }
        }
    }

    private function mostrarImagen($nombreArchivo, $pdf, $descripcion, $respuesta) {
        $urlImagen = "file/".$nombreArchivo;
        $file_ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $pdf->Cell(50, 5,  $descripcion);
        $pdf->Image($urlImagen, "", "", "30", '', $file_ext, '', '', false, 300, '', false, false, 0, false, false, false);        
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(50);
    }

    

    protected function imprimirPregunta($respuesta, $pdf, $descripcion){
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
    }

    protected function imprimirPreguntas($respuestas, $pdf, $seccion){
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
        $pdf->Ln(8);
        $color = true; 
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                if($color) {
                    $pdf->SetTextColor(0, 0, 0, 50);
                } else {
                    $pdf->SetTextColor(0, 0, 0, 100);
                }
                $pdf->SetFont('helvetica', 'I', 10);
                $descripcion = $respuesta['descripcionPregunta'];
                if($descripcion == '') { $descripcion = ' ';}
                if($respuesta['tipoPregunta'] == 'multiple') {
                    $this->imprimirSelectoresMultiples($respuesta, $pdf);
                } else {
                    $this->imprimirPregunta($respuesta, $pdf, $descripcion);

                }
                $color = !$color;
            }
        }
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

    protected function imprimirSecciones($pdf, $seccion){
        $pdf->SetTextColor(0, 0, 0, 100);
        $respuestas = $seccion['respuestas'];
        $pdf->Ln(5);
        
        if($seccion['descripcionSeccion'] == "Firmas del Permiso") {
            $this->imprimirFirmas($respuestas, $pdf, $seccion);
        } else {
            $this->imprimirPreguntas($respuestas, $pdf, $seccion);
        }
    }
    
}