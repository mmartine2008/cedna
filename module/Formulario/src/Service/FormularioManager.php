<?php

namespace Formulario\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Respuesta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use Zend\Console\Console;


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

    public function tieneRespuesta($respuesta) {
        if ((!$respuesta) || ($respuesta == "-1")){
            return false; 
        } 
        return true;
    }

    public function preguntaTieneOpciones($pregunta){
        $opciones = $this->getPreguntaOpcion($pregunta);
        if ($opciones) {
            return true;
        }
        return false;
    }

    public function altaRespuesta($pregunta, $seccion, $formulario,$respuesta, $destino, $opcion) {
        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        $Entidad->setSeccion($seccion);
        $Entidad->setFormulario($formulario);
        if($destino) {
            $Entidad->setDestino($destino);
        }
        if($opcion){
            $opcionEnt = $this->getOpcion($opcion);
            $Entidad->setOpcion($opcionEnt);
        } else {
            $Entidad->setDescripcion($respuesta);
        }
        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    public function altaRespuestasDestino($pregunta, $seccion, $formulario,$respuesta, $listaDestinos){
        foreach($listaDestinos as $item) {
            $destino = $item[0];
            $opcion = $item[1]->id;
            $this->altaRespuesta($pregunta, $seccion, $formulario,$respuesta, $destino, $opcion);
        }
    }

    public function getListaOpcionDestinoPregunta($pregunta, $respuestas) {
        $output = [];
        if($pregunta->getTipoPregunta()->esPeguntaMultiple()) {
            foreach ($respuestas as $resp) {
                $destino = $resp->destino;
                $opciones = $resp->opcion;
                if($opciones){
                    foreach($opciones as $opcion) {
                        $opcionDestino = Array();
                        $opcionDestino[] = $destino;
                        $opcionDestino[] = $opcion;
                        $output[]=$opcionDestino;
                    }
                }
            }
        }
        return $output;
    }

    public function altaRespuestasFormulario($datos) {
        $secciones = $datos->secciones;
        $idFormulario = $datos->idFormulario;
        $formularioEnt = $this->getFormulario($idFormulario);
        foreach ($secciones as $seccion) {
            $idSeccion = $seccion->id;
            $seccionEnt = $this->getSeccion($idSeccion);
            foreach ($seccion->preguntas as $pregunta) {
                $respuesta = $pregunta->respuesta;
                if ($this->tieneRespuesta($respuesta)){
                    $idPregunta = $pregunta->idPregunta;
                    $preguntaEnt = $this->getPregunta($idPregunta);
                    $listaOpcionDestino = $this->getListaOpcionDestinoPregunta($preguntaEnt, $respuesta);
                    if ($listaOpcionDestino){
                        $this->altaRespuestasDestino($preguntaEnt, $seccionEnt, $formularioEnt,$respuesta, $listaOpcionDestino);
                    } else {
                        $opcion = null;
                        if ($this->preguntaTieneOpciones($preguntaEnt)) {
                            $opcion = $this->getOpcion($respuesta);
                        }   
                        $this->altaRespuesta($preguntaEnt, $seccionEnt, $formularioEnt,$respuesta, null, $opcion);
                    }
                }
            }
        }
    }

    
}