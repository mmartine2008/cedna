<?php

namespace Formulario\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Respuesta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Seccion;


class FormularioManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
        
    }

    public function getFormularioJSON($id) {
        $formulario = $this->entityManager->getRepository(Formulario::class)
                                            ->findOneBy(['id' => $id]); 
        return $formulario->getJSON();
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
            $opcion = $item[1];
            $this->altaRespuesta($pregunta, $seccion, $formulario,$respuesta, $destino, $opcion);
        }
    }

    public function getListaOpcionDestinoPregunta($pregunta, $respuestas) {
        $output = [];
        if($pregunta->getTipoPregunta()->esPeguntaMultiple()) {
            foreach ($respuestas as $respuesta) {
                $destino = $respuesta->selector;
                $opciones = $respuesta->respuesta;
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
        foreach($secciones as $seccion) {
            $idSeccion = $seccion->id;
            $seccionEnt = $this->getSeccion($idSeccion);
            foreach($seccion->preguntas as $pregunta) {
                $respuesta = $pregunta->respuesta;
                if($this->tieneRespuesta($respuesta)){
                    $idPregunta = $pregunta->idPregunta;
                    $preguntaEnt = $this->getPregunta($idPregunta);
                    $listaOpcionDestino = $this->getListaOpcionDestinoPregunta($preguntaEnt, $respuesta);
                    if($listaOpcionDestino){
                        $this->altaRespuestasDestino($preguntaEnt, $seccionEnt, $formularioEnt,$respuesta, $listaOpcionDestino);
                    } else {
                        $opcion = null;
                        if($this->preguntaTieneOpciones($preguntaEnt)) {
                            $opcion = $this->getOpcion($respuesta);
                            $this->altaRespuesta($preguntaEnt, $seccionEnt, $formularioEnt,$respuesta, null, $opcion);
                        }   
                    }
                }
            }
        }
    }

    
}