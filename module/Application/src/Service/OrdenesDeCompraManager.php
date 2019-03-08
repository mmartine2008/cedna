<?php

namespace Application\Service;

use DBAL\Entity\OrdenesDeCompra;

class OrdenesDeCompraManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    private $catalogoManager;

    private $tareasManager;

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager, $tareasManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
        $this->tareasManager = $tareasManager;
    }

    /**
     * Recorre todas las tareas y devuelve el JSON de las tareas
     * que tienen asignada una orden de compra.
     *
     * @return void
     */
    public function getArrTareasJSONConOrdenesDeCompra(){
        $Tareas = $this->catalogoManager->getTareas();

        $output = [];
        foreach($Tareas as $Tarea){
            if ($Tarea->getOrdenDeCompra()){
                $output[] = $Tarea->getJSON();
            }
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    public function altaEdicionOrdenesDeCompra($jsonData, $idOrdenesDeCompra = null){
        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);

        if ($idOrdenesDeCompra){
            $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);
            $Tarea = $this->catalogoManager->getTareaPorOrdenDeCompra($OrdenesDeCompra);
        }else{
            $OrdenesDeCompra = new OrdenesDeCompra();
            $Tarea = null;
        }
        
        $OrdenesDeCompra->setFechaLiberacion($jsonData->fechaLiberacion);
        $OrdenesDeCompra->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($OrdenesDeCompra);
        $this->entityManager->flush();

        //cargo los datos de la orden de compra en el JSON
        $jsonData->ordenDeCompra = json_decode($OrdenesDeCompra->getJSON());

        if ($Tarea){
            $this->tareasManager->altaEdicionTareas($jsonData, $jsonData->solicitante->userName, $Tarea->getId());
        }else{
            $this->tareasManager->altaEdicionTareas($jsonData, $jsonData->solicitante->userName);
        }
    }
    
    public function borrarOrdenesDeCompra($idOrdenesDeCompra){
        $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($OrdenesDeCompra);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la orden de compra correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La orden de compra no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}