<?php

namespace Application\Service;

use DBAL\Entity\Tareas;
use DBAL\Entity\EstadoTarea;
use DBAL\Entity\Relevamientos;
use DBAL\Entity\Planificaciones;

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

            $Tareas->setFechaSolicitud(new \DateTime("now"));
            $Tareas->setEstadoTarea($EstadoTarea);
        }
        $Solicitante = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);
        $Tareas->setSolicitante($Solicitante);

        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);

        $Tareas->setNodo($Nodo);

        if (property_exists($jsonData, 'resumen')){
            $Tareas->setResumen($jsonData->resumen);
        }
        
        $Tareas->setDescripcion($jsonData->descripcion);

        if (property_exists($jsonData->ejecutor, 'id')){
            $Ejecutor = $this->catalogoManager->getUsuarios($jsonData->ejecutor->id);
            $Tareas->setEjecutor($Ejecutor);
        }
        
        if (property_exists($jsonData->responsable, 'id')){
            $Responsable = $this->catalogoManager->getUsuarios($jsonData->responsable->id);
            $Tareas->setResponsable($Responsable);
        }

        if (property_exists($jsonData->planificaTarea, 'id')){
            $PlanificaTarea = $this->catalogoManager->getUsuarios($jsonData->planificaTarea->id);
            $Tareas->setPlanificaTarea($PlanificaTarea);
        }

        if (property_exists($jsonData->ordenDeCompra, 'id')){
            $OrdenDeCompra = $this->catalogoManager->getOrdenesDeCompra($jsonData->ordenDeCompra->id);
            $Tareas->setOrdenDeCompra($OrdenDeCompra);
        }

        $this->entityManager->persist($Tareas);
        $this->entityManager->flush();
    }

    public function asignarFormularioTarea($jsonData, $Tareas){
        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->idFormulario);
        $Relevamiento = $Tareas->getRelevamiento();

        if ($Relevamiento){
            $Relevamiento->setFormulario($Formulario);
            $this->entityManager->persist($Relevamiento);
        }else{
            $Relevamiento = new Relevamientos();
            $Relevamiento->setFormulario($Formulario);
            
            $this->entityManager->persist($Relevamiento);
            $this->entityManager->flush();

            
            $Tareas->setRelevamiento($Relevamiento);
        }

        $this->entityManager->persist($Tareas);
        $this->entityManager->flush();
    }

    /**
     * Esta funcion guarda las planificaciones de una tarea especifica.
     * Recibe un JSON con las planificaciones a guardar y otro con las que se deben
     * eliminar de la base de datos.
     * 
     * Las planificaciones a guardar, estan divididas en las que reciben actualizacion (ya tienen id)
     * y las que son completamente nuevas.
     *
     * @param [JSON] $jsonData
     * @param [Tareas] $Tarea
     * @return void
     */
    function guardarPlanificacionTareaPorDia($jsonData, $Tarea){
        $arrPlanificaciones = $jsonData->planificaciones;
        $arrPlanificacionesEliminadas = $jsonData->planificacionesEliminadas;

        foreach($arrPlanificaciones as $planificacionJSON){
            if (property_exists($planificacionJSON, 'id')){
                $Planificaciones = $this->catalogoManager->getPlanificaciones($planificacionJSON->id);
            }else{
                $Planificaciones = new Planificaciones();
                $Planificaciones->setTarea($Tarea);
            }

            $Planificaciones->setFechaInicio($planificacionJSON->fechaInicio);
            $Planificaciones->setFechaFin($planificacionJSON->fechaFin);
            $Planificaciones->setHoraInicio($planificacionJSON->horaInicio);
            $Planificaciones->setHoraFin($planificacionJSON->horaFin);
            $Planificaciones->setObservaciones($planificacionJSON->observaciones);

            $this->entityManager->persist($Planificaciones);
        }

        $this->entityManager->flush();

        foreach($arrPlanificacionesEliminadas as $planificacionEliminada){
            $this->borrarPlanificacion($planificacionEliminada->id);
        }
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

    public function borrarPlanificacion($idPlanificaciones){
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificaciones);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Planificacion);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollBack();
        }

        return $mensaje;
    }
}