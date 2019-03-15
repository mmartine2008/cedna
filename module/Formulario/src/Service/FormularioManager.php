<?php

namespace Formulario\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Respuesta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use DBAL\Entity\Relevamientos;
use DBAL\Entity\EstadosRelevamiento;


class FormularioManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    private $catalogoManager;
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
        
    }

    public function getPregunta($id) {
        $pregunta = $this->entityManager->getRepository(Pregunta::class)
                                            ->findOneBy(['id' => $id]); 
        return $pregunta;
    }

    public function getSeccion($id) {
        $seccion = $this->entityManager->getRepository(Seccion::class)
                                            ->findOneBy(['id' => $id]); 
        return $seccion;
    }

    public function getFormulario($id) {
        $formulario = $this->entityManager->getRepository(Formulario::class)
                                            ->findOneBy(['id' => $id]); 
        return $formulario;
    }

    public function getOpcion($id) {
        $Opcion = $this->entityManager->getRepository(Opcion::class)
                                            ->findOneBy(['id' => $id]); 
        return $Opcion;
    }

    public function getPreguntaOpcion($idPregunta) {
        $Entidad = $this->entityManager->getRepository(PreguntaOpcion::class)
                                            ->findBy(['pregunta' => $idPregunta]); 
        return $Entidad;
    }

    public function getPreguntasxSeccion($seccion) {
        $preguntas = $this->entityManager->getRepository(SeccionPregunta::class)
                                            ->findBy(['seccion' => $seccion]); 
        return $preguntas;
    }

    public function getSeccionesxFormulario($formulario){
        $Secciones = $this->entityManager->getRepository(Seccion::class)
                                            ->findBy(['formulario' => $formulario]); 
        return $Secciones;
    }

    /**
     * Funcion que asignar un formulario a una planificacion.
     */
    public function asignarFormularioAPlanificacion($JsonData, $Planificacion){
        $Formulario = $this->catalogoManager->getFormulario($JsonData->formulario->id);

        $Relevamiento = $Planificacion->getRelevamiento();

        if ($Relevamiento){
            $Relevamiento->setFormulario($Formulario);
            $this->entityManager->persist($Relevamiento);
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            
            $Relevamiento = new Relevamientos();
            $Relevamiento->setFormulario($Formulario);
            $Relevamiento->setEstadoRelevamiento($EstadoParaEditar);
            
            $this->entityManager->persist($Relevamiento);
            $this->entityManager->flush();

            
            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
        }

        $this->entityManager->flush();
    }

    public function getPreguntasxFormulario($formulario) {
        $secciones = $this->getSeccionesxFormulario($formulario);
        $arregloPreg = [];
        foreach($secciones as $seccion){
            $preguntasxSeccion = $this->getPreguntasxSeccion($seccion);
            foreach($preguntasxSeccion as $pregunta) {
                $arregloPreg[] = $pregunta->getPregunta();
            }
        }
        return $arregloPreg;
    }

    public function getOpcionesFuncion($pregunta) {
        $strinfFuncion = $pregunta->getFuncion();
        $opciones = $this->catalogoManager->{$strinfFuncion}();
        return $opciones;
    }

    public function getJSONModificadoSelectSimple($pregunta, $form) {
        $secc = $form->secciones;
        foreach($secc as $seccion) {
            $preguntas = $seccion->preguntas;
            foreach($preguntas as $preguntaJSON) {
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta);
                    $preguntaJSON->opciones = $opciones;
                }
            }
        }
        return $form;
    }

    public function getJSONModificadoSelectMultiple($pregunta, $form) {
        $secciones = $form->secciones;
        foreach($secciones as $seccion) {
            $preguntas = $seccion->preguntas;
            foreach($preguntas as $preguntaJSON) {
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta);
                    $respuestas = $preguntaJSON->respuesta;
                    $destino = 'destino_0_id_'.$pregunta->getId();
                    foreach($respuestas as $respuesta) {
                        if($respuesta->destino == $destino){
                            $opcionesJSON = $opciones;
                            $respuesta->opcion = $opcionesJSON;
                        }
                    }
                }
            }
        }
        return $form;
    }

    public function getJSONActualizado($formulario){
        $preguntas = $this->getPreguntasxFormulario($formulario);
        $JSON = $formulario->getJSON();
        $formJSON = json_decode($JSON);
        foreach($preguntas as $pregunta) {
            if($pregunta->tieneFuncion()){
                $cantDestinos = $pregunta->getTipoPregunta()->getCantDestinos();
                if($cantDestinos > 0){
                    $formJSON = $this->getJSONModificadoSelectMultiple($pregunta, $formJSON);
                } else {
                    $formJSON = $this->getJSONModificadoSelectSimple($pregunta, $formJSON);
                }  
            }
        }
        return json_encode($formJSON);
    }

    public function getFormularioJSON($id) {
        $formulario = $this->entityManager->getRepository(Formulario::class)
                                            ->findOneBy(['id' => $id]); 

        return  $this->getJSONActualizado($formulario);
    }

    private function reagruparPorDestino($Respuestas) {
        $destinoAcum = "";
        $ArrayAcum = [];
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $destino = $Respuesta->getDestino();
            if($destinoAcum == $destino) {
                $ArrayAcum[] = $Respuesta;
            }
            if($destinoAcum != $destino) {
                $destinoAcum = $destino;
                if($ArrayAcum) {
                    $output[] = $ArrayAcum;
                    $ArrayAcum = [];
                }
            }
        }
        return $output;
    }


    private function getRespuestasAgrupadasPorPregunta($Respuestas) {
        $idAcum = -1;
        $ArrayAcum = [];
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $idPregunta = $Respuesta->getPregunta()->getId();
            
            if($idAcum != $idPregunta) {
                $idAcum = $idPregunta;
                if($ArrayAcum) {
                    $output[] = $ArrayAcum;
                    $ArrayAcum = [];
                }
            }
            $ArrayAcum[] = $Respuesta;
        }
        $output[] = $ArrayAcum;

        return $output;
    }

    public function getRespuestasSegunRelevamiento($Relevamiento){
        $Respuestas = $this->entityManager->getRepository(Respuesta::class)
                            ->findAll(); 
        $output = [];
        foreach($Respuestas as $Respuesta) {
            if ($Respuesta->getRelevamiento()->getId() == $Relevamiento->getId()) {
                $output[] = $Respuesta;
            }
        }
        return $this->getRespuestasAgrupadasPorPregunta($output);
    }

    private function getValorFuncion($funcion, $opcion){
        $opciones = $this->catalogoManager->{$funcion}();
        $objOpciones = json_decode(json_encode($opciones));

        foreach($objOpciones as $opcionFuncion) {
            if($opcionFuncion->id == $opcion){
                return $opcionFuncion->descripcion;
            }
        }
    }

    private function getRespuestaModificada($Respuesta) {
        $JSON = $Respuesta->getJSON();
        $respuestaDec = json_decode($JSON);

        $pregunta = $respuestaDec->pregunta;
        if($pregunta->cerrada == 1) {
            if($pregunta->funcion) {
                $valorOpcion = $this->getValorFuncion($pregunta->funcion, $respuestaDec->opcion);
            } else {
                $valorOpcion = $this->getOpcion($respuestaDec->opcion)->getDescripcion();
            }
            $respuestaDec->respuesta = $valorOpcion;
        }
       
        return json_decode(json_encode($respuestaDec), true);
    }

    private function getArrayRespuestasModificadas($Respuestas) {
        $output = [];
        $destinoAcum = "";
        $ArrayAcum = [];
        foreach($Respuestas as $Respuesta){
            $destino = $Respuesta->getDestino();
            if($destinoAcum != $destino) {
                if($ArrayAcum) {
                    $output[] = ['destino' => $destinoAcum,
                                'respuestas' => $ArrayAcum];
                    
                    $ArrayAcum = [];
                }
                $destinoAcum = $destino;
            }
            $ArrayAcum[] = $this->getRespuestaModificada($Respuesta);
        }
        $output[] = ['destino' => $destinoAcum,
                    'respuestas' => $ArrayAcum];
        
        return $output;
    }

    public function getRespuestasPorPreguntas($Respuestas) {
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta()->getDescripcion(); 
            $destinos = $Respuesta->getPregunta()->getTipoPregunta()->esPeguntaMultiple();
            if(!$destinos) {
                $respuestaOutput = $this->getRespuestaModificada($Respuesta);
            }
        }

        if($destinos) {
            $respuestaOutput = $this->getArrayRespuestasModificadas($Respuestas);
        }

        $output[]= ['descripcionPregunta' => $pregunta,
                    'poseeDestinos' => $destinos,
                    'respuesta' => $respuestaOutput];
        return $output;
    } 


    private function respuestasSonTipoArchivo($Respuestas) {
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta();
            $tipoPregunta = $pregunta->getTipoPregunta();
            if($tipoPregunta->getDescripcion() == 'file'){
                return true;
            }
            return false;
        }
    }

    private function respuestasPertenecenASeccion($Respuestas, $idSeccion) {
        foreach($Respuestas as $Respuesta) {
            if($Respuesta->getSeccion()->getId() == $idSeccion){
                return true;
            }
            return false;
        }
    }

    private function getRespuestaPorSeccion($RespuestasRelevamiento, $idSeccion){
        $respuestas = [];
        foreach($RespuestasRelevamiento as $Respuestas){
            if($this->respuestasPertenecenASeccion($Respuestas, $idSeccion)){
                if(!$this->respuestasSonTipoArchivo($Respuestas)){
                    $respuestas[] = $this->getRespuestasPorPreguntas($Respuestas);
                }
            } 
        } 
        
        return $respuestas ;
    } 

    private function getSeccionesPorFormulario($Relevamiento){
        $RespuestasRelevamiento = $this->getRespuestasSegunRelevamiento($Relevamiento);
        $secciones = $Relevamiento->getFormulario()->getSecciones();
        foreach($secciones as $seccion) {
            $output[] = ['idSeccion' => $seccion->getId(), 'descripcionSeccion' =>$seccion->getDescripcion(), 
                    'respuestas' => $this->getRespuestaPorSeccion($RespuestasRelevamiento, $seccion->getId())];
        }

        return $output;
    }

    public function getRespuestas($Relevamiento){
        $output = [];
       
        $output = ['idRelevamiento' =>$Relevamiento->getId(), 
                    'descripcionFormulario' => $Relevamiento->getFormulario()->getNombre(),
                    'secciones' => $this->getSeccionesPorFormulario($Relevamiento)
                    ];
     
        return $output;
    }

    public function tieneRespuesta($respuesta) {
        if ((!$respuesta) || ($respuesta == "-1")){
            return false; 
        } 
        return true;
    }

    public function altaRespuesta($pregunta, $seccion, $relevamiento, $respuesta, $destino, $opcion) {
        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        $Entidad->setSeccion($seccion);
        $Entidad->setRelevamiento($relevamiento);
        $Entidad->setDestino($destino);
        if($opcion){
            $Entidad->setOpcion($opcion);
        } else {
            $Entidad->setDescripcion($respuesta);
        }
        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    public function altaRespuestasDestino($pregunta, $seccion, $Relevamiento, $respuesta, $listaDestinos){
        foreach($listaDestinos as $item) {
            $destino = $item[0];
            $opcion = $item[1]->id;
            $this->altaRespuesta($pregunta, $seccion, $Relevamiento, $respuesta, $destino, $opcion);
        }
    }

    public function getOpcionDestino($opciones, $destino){
        $output = [];
        foreach($opciones as $opcion) {
            $opcionDestino = Array();
            $opcionDestino[] = $destino;
            $opcionDestino[] = $opcion;
            $output[] = $opcionDestino;
        }
        return $output;
    }
    

    public function getListaOpcionDestinoPregunta($pregunta, $respuestas) {
        $output = [];
        if($pregunta->getTipoPregunta()->esPeguntaMultiple()) {
            foreach ($respuestas as $resp) {
                $destino = $resp->nombre; //nombre destino
                $opciones = $resp->opcion;
                if($opciones){
                    $opcionesDestinos = $this->getOpcionDestino($opciones, $destino);
                    $output = array_merge($opcionesDestinos, $output);
                }
            }
        }
        return $output;
    }

    public function altaRespuestaSegunTipoRespuesta($preguntaEnt, $seccionEnt, $Relevamiento, $respuesta){
        $listaOpcionDestino = $this->getListaOpcionDestinoPregunta($preguntaEnt, $respuesta);
        if ($listaOpcionDestino){
            $this->altaRespuestasDestino($preguntaEnt, $seccionEnt, $Relevamiento, $respuesta, $listaOpcionDestino);
        } else {
            $opcion = null;
            if ($preguntaEnt->tieneOpciones()) {
                $opcion = $respuesta;
            }   
            $this->altaRespuesta($preguntaEnt, $seccionEnt, $Relevamiento, $respuesta, null, $opcion);
        }
    }

    public function altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento){
        $respuesta = $pregunta->respuesta;
        if ($this->tieneRespuesta($respuesta)){
            $idPregunta = $pregunta->idPregunta;
            $preguntaEnt = $this->getPregunta($idPregunta);
            $this->altaRespuestaSegunTipoRespuesta($preguntaEnt, $seccionEnt, $Relevamiento, $respuesta);
        }
    }

    public function altaRespuestaPreguntasGeneradas($preguntasGeneradas, $seccionEnt, $Relevamiento){
        foreach($preguntasGeneradas as $preguntaGenerada) {
            if($preguntaGenerada->estado == "block"){
                $pregunta = $preguntaGenerada->preguntaGenerada;
                $this->altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento);
            }
        }
    }

    public function altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento){
        $idSeccion = $seccion->id;
        $seccionEnt = $this->getSeccion($idSeccion);
        foreach ($seccion->preguntas as $pregunta) {
            $this->altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento);
            if($pregunta->preguntasGeneradas) {
                $this->altaRespuestaPreguntasGeneradas($pregunta->preguntasGeneradas, $seccionEnt, $Relevamiento);
            }
        }
    }

    public function altaRespuestasFormulario($datos, $idPlanificacion) {
        $secciones = $datos->secciones;
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();
        foreach ($secciones as $seccion) {
            $this->altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento);
        }
    }

    
}