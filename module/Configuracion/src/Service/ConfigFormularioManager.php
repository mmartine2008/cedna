<?php

namespace Configuracion\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use DBAL\Entity\Pregunta;

class ConfigFormularioManager{
    
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

    public function altaEdicionFormularios($jsonData, $idFormulario = null){
        if ($idFormulario){
            $Formulario = $this->catalogoManager->getFormulario($idFormulario);
        }else{
            $Formulario = new Formulario();
        }

        $Formulario->setNombre($jsonData->nombre);
        $Formulario->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Formulario);
        $this->entityManager->flush();
    }

    public function borrarFormularios($idFormulario){
        $Formulario = $this->catalogoManager->getFormulario($idFormulario);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Formulario);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el parametro correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El parametro no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
    
    public function altaSecciones($jsonData, $idFormulario){
        $Seccion = new Seccion();
        $Formulario = $this->catalogoManager->getFormularios($idFormulario);
        $Seccion->setFormulario($Formulario);
        $Seccion->setNombre($jsonData->nombre);
        $Seccion->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Seccion);
        $this->entityManager->flush();
    }

    private function enlazarPregunta($Pregunta, $Seccion, $requerido) {
        $SeccionPregunta = $this->catalogoManager->getSeccionPregunta($Seccion, $Pregunta);
        
        if(!$SeccionPregunta) {
            $SeccionPregunta = new SeccionPregunta();
            $SeccionPregunta->setSeccion($Seccion);
            $SeccionPregunta->setPregunta($Pregunta);
            $SeccionPregunta->setRequerido($requerido);

            $this->entityManager->persist($SeccionPregunta);
            $this->entityManager->flush();
        } else {
            $SeccionPregunta->setRequerido($requerido);
        }
    }

    private function desenlazarPregunta($Pregunta, $Seccion) {
        $seccionPregunta = $this->catalogoManager->getSeccionPregunta($Seccion, $Pregunta);        
        
        if($seccionPregunta) {
            $this->entityManager->beginTransaction();         
            try {
                $this->entityManager->remove($seccionPregunta);

                $this->entityManager->flush();
                $this->entityManager->commit();

            } catch (Exception $e) {
                $this->entityManager->rollBack();
            }
        }
    }

    private function enlazarSeccionPreguntas($Seccion, $preguntasEnlazadas, $requeridos) {
        foreach ($preguntasEnlazadas as $idPregunta => $value) {
            $Pregunta = $this->catalogoManager->getPreguntas($idPregunta);
            if ($value) {
                $this->enlazarPregunta($Pregunta, $Seccion, $requeridos->$idPregunta);
            } else if (!$value) {
                $this->desenlazarPregunta($Pregunta, $Seccion);
            }
        }
    }

    public function edicionSecciones($jsonData, $idSeccion, $preguntasEnlazadas, $requeridos){
        $Seccion = $this->catalogoManager->getSecciones($idSeccion);
        
        $this->enlazarSeccionPreguntas($Seccion, $preguntasEnlazadas, $requeridos);
        $Seccion->setNombre($jsonData->nombre);
        $Seccion->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Seccion);
        $this->entityManager->flush();

        return $Seccion->getFormulario()->getId();
    }

    private function preguntaPerteneceASeccion($Pregunta, $Seccion) {
        $seccionPregunta = $this->catalogoManager->getSeccionPregunta($Seccion, $Pregunta);
        if($seccionPregunta) {
            return true;
        }
        return false;
    }

    public function getEstadoPreguntasSeccion($idSeccion) {
        $Seccion = $this->catalogoManager->getSecciones($idSeccion);
        $Preguntas = $this->catalogoManager->getPreguntas();
        foreach ($Preguntas as $Pregunta) {
            if ($this->preguntaPerteneceASeccion($Pregunta, $Seccion)) {
                $Estados[$Pregunta->getId()] = 1;
            } else {
                $Estados[$Pregunta->getId()] = 0;
            }
        }
        return $Estados;
    }

    public function altaEdicionPreguntas($jsonData, $idPregunta = null){
        if ($idPregunta){
            $Pregunta = $this->catalogoManager->getPregunta($idPregunta);
        }else{
            $Pregunta = new Pregunta();
        }

        $Pregunta->setDescripcion($jsonData->descripcion);
        $Pregunta->setTipoPregunta($jsonData->tipoPregunta);
        $Pregunta->setTieneOpciones($jsonData->tieneOpciones);

        if($jsonData->funcion != "") {
            $Pregunta->setFuncion($jsonData->funcion);
        }

        $this->entityManager->persist($Pregunta);
        $this->entityManager->flush();
    }
}