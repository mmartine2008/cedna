<?php

namespace Formulario\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Respuesta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;
use DBAL\Entity\Pregunta;


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

    public function getRespuestasFormularioJSON($id) {
        $respuestas = $this->entityManager->getRepository(Respuesta::class)
                                            ->findOneBy(['id' => $id]); 
        return $respuestas->getJSON();
    }

    public function getPregunta($id) {
        $pregunta = $this->entityManager->getRepository(Pregunta::class)
                                            ->findOneBy(['id' => $id]); 
        return $pregunta;
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

    public function altaRespuesta($idPregunta, $respuesta) {
        $pregunta = $this->getPregunta($idPregunta);

        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        
        if($this->preguntaTieneOpciones($idPregunta)) {
            $opcion = $this->getOpcion($respuesta);
            $Entidad->setOpcion($opcion);
        } else {
            $Entidad->setDescripcion($respuesta);
        }

        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    public function altaRespuestasFormulario($respuestas) {
        foreach($respuestas as $respuesta){
            if($this->tieneRespuesta($respuesta->respuesta)){
                $idPregunta = $respuesta->id;
                $this->altaRespuesta($idPregunta, $respuesta->respuesta);
            }
        }
    }

    
}