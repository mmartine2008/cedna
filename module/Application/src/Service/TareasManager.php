<?php

namespace Application\Service;

use DBAL\Entity\Tareas;

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

    public function altaEdicionTareas($jsonData, $idTareas = null){
        if ($idTareas){
            $Tareas = $this->catalogoManager->getTareas($idTareas);
        }else{
            $EstadoTarea = $this->catalogoManager->getEstadoTarea($jsonData->estadoTarea->id);
            
            $Tareas = new Tareas();
            $Tareas->setFechaSolicitud(new \DateTime("now"));
            $Tareas->setEstadoTarea($EstadoTarea);
        }

        // $Tareas->setNombre($jsonData->nombre);
        // $Tareas->setApellido($jsonData->apellido);
        // $Tareas->setCuit($jsonData->cuit);
        // $Tareas->setTelefono($jsonData->telefono);
        // $Tareas->setEmail($jsonData->email);

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