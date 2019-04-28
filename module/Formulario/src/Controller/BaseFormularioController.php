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

    protected function getStringRespuestas($respuestas) {
        $output = [];
        foreach($respuestas as $respuesta) {
            $output[] = $respuesta['respuesta'];
        }

        $string = implode(" - ", $output);
        return $string;
    }

    protected function imprimirSelectoresMultiples($respuesta, $pdf) {
        $this->insertarSaltoPagina($pdf, 40);                
        $respuestas = $respuesta['respuesta'];
        foreach($respuestas as $resp) {
            $string = $this->getStringRespuestas($resp['respuestas']);
            $listaDestinos = $this->getDestinos();
            $pdf->SetFont('helvetica', '', 10);
            $pdf->MultiCell(0, 10, $string."\n", 1, 'L', 0, 0, '' ,'', true);
            $pdf->Ln(7);
        }
    }

    private function mostrarImagen($nombreArchivo, $pdf, $descripcion, $respuesta) {
        $datos_archivo = $this->FormularioManager->getPathFiles();
        $name = $datos_archivo['path']."/".$nombreArchivo;

        $urlImagen = $name;
        $file_ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $pdf->Cell(50, 5,  $descripcion);
        $pdf->Image($urlImagen, "", "", 40, 40, $file_ext, '', '', false, 300, '', false, false, 0, false, false, false);        
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(45);
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

    protected function imprimirPreguntas($respuestas, $pdf, $seccion, $color){
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(35, 5, $seccion['descripcionSeccion']);
        $pdf->Ln(8);
    
        foreach ( $respuestas as $respuestaxRespuesta) { 
            foreach ( $respuestaxRespuesta as $respuesta) { 
                $pdf->SetFont('helvetica', 'B', 10);
                $descripcion = $respuesta['descripcionPregunta'];
                if($descripcion == '') { 
                    $descripcion = ' ';
                } else {
                    $descripcion = $descripcion.":  ";
                }
                if($respuesta['tipoPregunta'] == 'multiple') {
                    $this->imprimirSelectoresMultiples($respuesta, $pdf);
                } else {
                    $this->imprimirPregunta($respuesta, $pdf, $descripcion);
                }
            }
        }
        return $color;
    }

    private function imprimirTresFirmas($pdf, $list, $i) {
        $pdf->Cell(13, 5,  "");

        for($j = 0; $j< 3 ; $j++) {
            $pdf->Cell(60, 5,  "____________________");
        }
        $pdf->Ln(5);

        $pdf->Cell(20, 5,  "");
        for($j = 0; $j< 3 ; $j++) {
            $pdf->Cell(60, 5,  $list[$i+$j]);
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
                        $pdf->Cell(60, 5,  "____________________");
                        $pdf->Cell(60, 5,  "____________________");
                        $pdf->Ln(5);

                        $pdf->Cell(40, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                        $pdf->Cell(60, 5,  $list[$i+1]);
                    } else if($modulo == 1) {
                        $pdf->Cell(70, 5,  "");
                        $pdf->Cell(60, 5,  "____________________");
                        $pdf->Ln(5);

                        $pdf->Cell(80, 5,  "");
                        $pdf->Cell(60, 5,  $list[$i]);
                    } else {
                        $this->imprimirTresFirmas($pdf, $list, $i);
                    }
                } else {
                    $this->imprimirTresFirmas($pdf, $list, $i);
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

    private function insertarSaltoPagina($pdf, $size){
        $posicionY = $pdf->GetY();
        $tamanio_pagina = $pdf->getPageHeight() ;
        if ($tamanio_pagina - $posicionY <= $size) { 
            $pdf->AddPage(); 
        }
    }

    protected function imprimirFirmas($respuestas, $pdf, $seccion) {
        $pdf->Ln(10);
        $this->insertarSaltoPagina($pdf, 80);
        $pdf->SetFont('helvetica', 'B', 12);
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
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 5, $data['descripcionFormulario'], 0, 1, 'C');

        $color = true;
        foreach ($data['secciones'] as $seccion) {
            $color = $this->imprimirSecciones($pdf, $seccion, $color);
        }
    }

    private function imprimirDetallesPlanificacion($pdf, $Planificacion) {
        $pdf->SetFont('helvetica', '', 10);

        $y = $pdf->getY();
        $left_column = "<b>Planificación:  </b> ".$Planificacion->titulo;
        $pdf->writeHTMLCell(0, '', '', $y, $left_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(2);
        
        $y = $pdf->getY();
        $left_column = "<b>Observaciones:  </b> ".$Planificacion->observaciones;
        $pdf->writeHTMLCell(0, '', '', $y, $left_column, 0, 1, 0, true, 'L', true);
        $y_fin = $pdf->getY();
        $pdf->Ln(2);

        $y = $pdf->getY();
        $time = strtotime($Planificacion->fechaInicio);
        $date = date('d/m/Y',$time);
        $left_column = "<b>Fecha de Inicio: </b>  ".$date;

        $time = strtotime($Planificacion->fechaFin);
        $date = date('d/m/Y',$time);
        $right_column = "<b>Fecha de Finalización: </b>  ".$date;

        $pdf->writeHTMLCell(80, '', '', $y, $left_column, 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(80, '', '', '', $right_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(2);

        $y = $pdf->getY();
        $time = strtotime($Planificacion->horaInicio);
        $date = date('H:m',$time);
        $left_column = "<b>Hora de Inicio: </b>  ".$date;

        $time = strtotime($Planificacion->horaFin);
        $date = date('H:m',$time);
        $right_column = "<b>Hora de Finalización: </b>  ".$date;
        
        $pdf->writeHTMLCell(80, '', '', $y, $left_column, 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(80, '', '', '', $right_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(5);

        $html ='<hr>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    protected function imprimirInformacionPlanificacion($pdf, $Planificacion) {
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 5, "Detalles de la Planificación", 0, 1, 'C');
        $pdf->Ln(5);
        $this->imprimirDetallesPlanificacion($pdf, $Planificacion);
    }

    private function imprimirDetallesObra($pdf, $Tarea) {
        //ver si poner nodo y si esta bien planificaTarea
        $pdf->SetFont('helvetica', '', 10);
        
        $y = $pdf->getY();
        $left_column = "<b>Usuario que planifica la Obra: </b>  ".$Tarea->planificaTarea->nombre;
        $right_column = "<b>Solicitante: </b>  ".$Tarea->solicitante->nombre;
        $pdf->writeHTMLCell(80, '', '', $y, $left_column, 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(80, '', '', '', $right_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(2);

        $y = $pdf->getY();
        $left_column = "<b>Ejecutor:  </b> ".$Tarea->ejecutor->nombre;
        $right_column = "<b>Responsable: </b>  ".$Tarea->responsable->nombre;
        $pdf->writeHTMLCell(80, '', '', $y, $left_column, 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(80, '', '', '', $right_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(5);

        $y = $pdf->getY();
        $left_column = "<b>Descripcion:  </b> ".$Tarea->descripcion;
        $pdf->writeHTMLCell(0, '', '', $y, $left_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(2);

        $y = $pdf->getY();
        $left_column = "<b>Tipo de Planificacion: </b>  ".$Tarea->tipoPlanificacion->descripcion;
        $pdf->writeHTMLCell(0, '', '', $y, $left_column, 0, 1, 0, true, 'L', true);
        $pdf->Ln(5);

        $html ='<hr>';
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    protected function imprimirInformacionTarea($pdf, $Tarea) {
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 5, "Detalles de la Obra", 0, 1, 'C');
        $pdf->Ln(5);
        $this->imprimirDetallesObra($pdf, $Tarea);
    }
    
}