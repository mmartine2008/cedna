<?php

namespace Application\Service;

use DBAL\Entity\Tareas;
use DBAL\Entity\EstadoTarea;

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
        if ($idTareas){
            $Tareas = $this->catalogoManager->getTareas($idTareas);
        }else{
            $EstadoTarea = $this->catalogoManager->getEstadoTarea(EstadoTarea::ID_ESTADO_SOLICITADA);
            
            $Tareas = new Tareas();

            $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

            $Tareas->setSolicitante($UsuarioActivo);
            $Tareas->setFechaSolicitud(new \DateTime("now"));
            $Tareas->setEstadoTarea($EstadoTarea);
        }

        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);
        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->id);

        $Tareas->setNodo($Nodo);
        $Tareas->setFormulario($Formulario);
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