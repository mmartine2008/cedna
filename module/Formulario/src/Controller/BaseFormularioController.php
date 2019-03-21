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

    protected function imprimirPregunta($respuesta, $pdf, $descripcion){
        $pdf->Cell(50, 5,  $descripcion);
        $pdf->SetFont('helvetica', '', 12);
        $resp = $respuesta['respuesta'];
        $pdf->Cell(45, 5, $resp['respuesta']);
        $pdf->Ln(10);
    }

    protected function imprimirPreguntas($respuestas, $pdf){
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

    protected function imprimirFirmasSeleccionadas($listaDestinos, $pdf, $list, $destino) {
        if($listaDestinos[$destino] == "Seleccionados") {
            $i = 0;
            $cantFirmas = count($list);
            $modulo = $cantFirmas%3;
            $pdf->SetFont('helvetica', '', 12);
            while($i < count($list)){
                if($i+3 >= count($list)) {
                    if($modulo == 2) {
                        $pdf->Cell(30, 5,  "");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Ln(10);

                        $pdf->Cell(40, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                        $pdf->Cell(60, 5,  $list[$i+1]);
                    } else {
                        $pdf->Cell(50, 5,  "");
                        $pdf->Cell(60, 5,  "__________________");
                        $pdf->Ln(10);

                        $pdf->Cell(80, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                    }
                } else {
                    $pdf->Cell(10, 5,  "");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Cell(60, 5,  "__________________");
                    $pdf->Ln(10);

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

    protected function imprimirRespuestasFirmas($respuestas, $pdf){
        foreach($respuestas as $resp) {
            $pdf->SetFont('helvetica', 'B', 12);
            $list = $this->getListaRespuestas($resp['respuestas']);
            $destino = substr($resp['destino'], 8, 1);
            $listaDestinos = $this->getDestinos();
            $this->imprimirFirmasSeleccionadas($listaDestinos, $pdf, $list, $destino);
        }
    }

    protected function imprimirFirmas($respuestas, $pdf) {
        $pdf->Ln(20);
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                $respuestas = $respuesta['respuesta'];
                $this->imprimirRespuestasFirmas($respuestas, $pdf);
            }
        }
    }


    protected function imprimirSecciones($pdf, $seccion){
        $respuestas = $seccion['respuestas'];
        if($respuestas) {
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', '', 16);
            $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
            $pdf->Ln(18);
            if($seccion['descripcionSeccion'] == "Firmas del Permiso") {
                $this->imprimirFirmas($respuestas, $pdf);
            } else {
                $this->imprimirPreguntas($respuestas, $pdf);
            }
        }
    }
    
}
