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

    public function getRespuestasFormularioJSON($idFormulario) {
        $respuestas = $this->entityManager->getRepository(Respuesta::class)
                                            ->findAll(); 
        // foreach($respuestas as $respuesta) {
        //     if($this->respuestaEsDeFormulario($idFormulario)){

        //     }
        // }
        
        // if($respuestas){
        //     return $respuestas->getJSON();
        // } else {
        //     return "";
        // }
        return "";
        
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

    public function getOpcion($descripcion) {
        $Opcion = $this->entityManager->getRepository(Opcion::class)
                                            ->findOneBy(['descripcion' => $descripcion]); 
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

    public function preguntaTieneOpciones($idPregunta){
        $opciones = $this->getPreguntaOpcion($idPregunta);
        if ($opciones) {
            return true;
        }
        return false;
    }

    public function altaRespuesta($idPregunta, $idSeccion, $respuesta) {
        $pregunta = $this->getPregunta($idPregunta);
        $seccion = $this->getSeccion($idSeccion);

        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        $Entidad->setSeccion($seccion);
        
        if($this->preguntaTieneOpciones($idPregunta)) {
            $opcion = $this->getOpcion($respuesta);
            $Entidad->setOpcion($opcion);
        } else {
            $Entidad->setDescripcion($respuesta);
        }

        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    public function altaRespuestasFormulario($datos) {
        $secciones = $datos->secciones;
        foreach($secciones as $seccion) {
            $idSeccion = $seccion->id;
            foreach($seccion->preguntas as $pregunta) {
                $respuesta = $pregunta->respuesta;
                if($this->tieneRespuesta($respuesta)){
                    $idPregunta = $pregunta->idPregunta;
                    $this->altaRespuesta($idPregunta, $idSeccion, $respuesta);
                }
            }
        }
    }

    
}