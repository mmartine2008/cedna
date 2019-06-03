<?php

namespace Configuracion\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;

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

    private function desenlazarPreguntas($Seccion) {
        $ArraySeccionPregunta = $this->catalogoManager->getSeccionesPreguntasPorSeccion($Seccion);

        foreach($ArraySeccionPregunta as $SeccionPregunta) {
            $this->entityManager->beginTransaction();         
            try {
                $this->entityManager->remove($SeccionPregunta);
                $this->entityManager->flush();

                $this->entityManager->commit();

            } catch (Exception $e) {
                $this->entityManager->rollBack();
            }
        }
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


    public function borrarSecciones($idSeccion){
        $Seccion = $this->catalogoManager->getSecciones($idSeccion);
        $this->desenlazarPreguntas($Seccion);
        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Seccion);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la seccion correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La seccion no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }


    public function altaEdicionFormularios($jsonData, $idFormulario = null){
        if ($idFormulario){
            $Formulario = $this->catalogoManager->getSeccion($idFormulario);
        }else{
            $Formulario = new Formulario();
        }

        $Formulario->setNombre($jsonData->nombre);
        $Formulario->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Formulario);
        $this->entityManager->flush();
    }

    public function borrarSeccionesPorFormulario($Formulario) {
        $Secciones = $this->catalogoManager->getSeccionesPorFormulario($Formulario); 
        foreach($Secciones as $Seccion){
            $this->borrarSecciones($Seccion->getId());
        }
    }

    public function borrarFormularios($idFormulario){
        $Formulario = $this->catalogoManager->getFormulario($idFormulario);
        $this->borrarSeccionesPorFormulario($Formulario);
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

    private function enlazarPreguntas($SeccionesPreguntas, $SeccionClon) {
        foreach($SeccionesPreguntas as $SeccionPregunta) {
            $Pregunta = $SeccionPregunta->getPregunta();
            $requerido = $SeccionPregunta->getRequerido();
            $this->enlazarPregunta($Pregunta, $SeccionClon, $requerido);
        }
    }
    public function clonarSeccion($idSeccion){
        $Seccion = $this->catalogoManager->getSecciones($idSeccion);
        $SeccionClon = new Seccion();
        $SeccionClon->setNombre($Seccion->getNombre());
        $SeccionClon->setDescripcion($Seccion->getDescripcion());

        $this->entityManager->persist($SeccionClon);
        $this->entityManager->flush();

        $this->enlazarPreguntas($Seccion->getSeccionPreguntas(), $SeccionClon);
    }
    
    public function altaSecciones($jsonData){
        $Seccion = new Seccion();
        $Seccion->setNombre($jsonData->nombre);
        $Seccion->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Seccion);
        $this->entityManager->flush();
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
    }

    
    private function preguntaPerteneceASeccion($Pregunta, $Seccion) {
        $seccionPregunta = $this->catalogoManager->getSeccionPregunta($Seccion, $Pregunta);
        if($seccionPregunta) {
            return true;
        }
        return false;
    }

    private function preguntaPerteneceYEsRequeridaSeccion($Pregunta, $Seccion) {
        $seccionPregunta = $this->catalogoManager->getSeccionPregunta($Seccion, $Pregunta);
        if(($seccionPregunta) && ($seccionPregunta->esRequerida())) {
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

    public function getEstadoRequiredPreguntasSeccion($idSeccion) {
        $Seccion = $this->catalogoManager->getSecciones($idSeccion);
        $Preguntas = $this->catalogoManager->getPreguntas();
        foreach ($Preguntas as $Pregunta) {
            if ($this->preguntaPerteneceYEsRequeridaSeccion($Pregunta, $Seccion)) {
                $Estados[$Pregunta->getId()] = 1;
            } else {
                $Estados[$Pregunta->getId()] = 0;
            }
        }
        return $Estados;
    }

    private function altaOpcion($descripcion) {
        $Opcion = new Opcion();
        $Opcion->setDescripcion($descripcion);

        $this->entityManager->persist($Opcion);
        $this->entityManager->flush();
        
        return $Opcion;
    }

    private function altaOpcionPregunta($Opcion, $Pregunta) {
        $PreguntaOpcion = new PreguntaOpcion;

        $PreguntaOpcion->setOpcion($Opcion);
        $PreguntaOpcion->setPregunta($Pregunta);

        $this->entityManager->persist($PreguntaOpcion);
        $this->entityManager->flush();
    }

    private function crearOpciones($stringOpciones, $Pregunta) {
        $arrayOpciones = explode("-", $stringOpciones);
    
        foreach ($arrayOpciones as $descripcion) {
            $Opcion = $this->altaOpcion($descripcion);
            var_dump($Opcion);
            $this->altaOpcionPregunta($Opcion, $Pregunta);
        }
    }

    public function altaEdicionPreguntas($jsonData, $idPregunta = null){
        if ($idPregunta){
            $Pregunta = $this->catalogoManager->getPreguntas($idPregunta);
        }else{
            $Pregunta = new Pregunta();
        }

        $Pregunta->setDescripcion($jsonData->descripcion);
        $TipoPregunta = $this->catalogoManager->getTipoPregunta($jsonData->tipo);
        $Pregunta->setTipoPregunta($TipoPregunta);

        $tieneOpciones = 0;
        if($jsonData->opcion != '') {
            $tieneOpciones = 1;
        }
        if($jsonData->funcion != '') {
            $tieneOpciones = 1;
            $Pregunta->setFuncion($jsonData->funcion);
        }
        $Pregunta->setTieneOpciones($tieneOpciones);

        $this->entityManager->persist($Pregunta);
        $this->entityManager->flush();

        if($jsonData->opcion != '') {
            $this->crearOpciones($jsonData->opcion, $Pregunta);            
        }
    }

    public function borrarPreguntas($idPregunta){
        $Pregunta = $this->catalogoManager->getPreguntas($idPregunta);
        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Pregunta);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la pregunta correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La pregunta no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}