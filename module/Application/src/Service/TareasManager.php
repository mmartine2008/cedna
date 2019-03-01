<?php

namespace Application\Service;

use DBAL\Entity\Tareas;
use DBAL\Entity\EstadoTarea;
use DBAL\Entity\Relevamientos;

class TareasManager {
    
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

    public function altaEdicionTareas($jsonData, $userName, $idTareas = null){

        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->idFormulario);

        if ($idTareas){
            $Tareas = $this->catalogoManager->getTareas($idTareas);

            $Relevamiento = $Tareas->getRelevamiento();
            $Relevamiento->setFormulario($Formulario);
            $this->entityManager->persist($Relevamiento);
        }else{
            $Relevamiento = new Relevamientos();
            $Relevamiento->setFormulario($Formulario);
            
            $this->entityManager->persist($Relevamiento);
            $this->entityManager->flush();

            $EstadoTarea = $this->catalogoManager->getEstadoTarea(EstadoTarea::ID_ESTADO_SOLICITADA);
            
            $Tareas = new Tareas();

            $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

            $Tareas->setSolicitante($UsuarioActivo);
            $Tareas->setFechaSolicitud(new \DateTime("now"));
            $Tareas->setEstadoTarea($EstadoTarea);
            $Tareas->setRelevamiento($Relevamiento);
        }

        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);
        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->idFormulario);

        $Tareas->setNodo($Nodo);
        $Tareas->setResumen($jsonData->resumen);
        $Tareas->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Tareas);
        $this->entityManager->flush();
    }
    
    public function borrarTareas($idTareas){
        $Tareas = $this->catalogoManager->getTareas($idTareas);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Tareas);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la tarea correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La tarea no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}