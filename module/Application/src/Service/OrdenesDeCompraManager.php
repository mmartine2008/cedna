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

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
    }

    public function altaEdicionOrdenesDeCompra($jsonData, $idOrdenesDeCompra = null){
        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);
        $Ejecutor = $this->catalogoManager->getUsuarios($jsonData->ejecutor->id);
        $Solicitante = $this->catalogoManager->getUsuarios($jsonData->solicitante->id);
        $Responsable = $this->catalogoManager->getUsuarios($jsonData->responsable->id);
        $PlanificaTarea = $this->catalogoManager->getUsuarios($jsonData->planificaTarea->id);

        if ($idOrdenesDeCompra){
            $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);
        }else{
            $OrdenesDeCompra = new OrdenesDeCompra();
        }
        
        $OrdenesDeCompra->setSolicitante($Solicitante);
        $OrdenesDeCompra->setEjecutor($Ejecutor);
        $OrdenesDeCompra->setNodo($Nodo);
        $OrdenesDeCompra->setResponsable($Responsable);
        $OrdenesDeCompra->setPlanificaTarea($PlanificaTarea);
        $OrdenesDeCompra->setFechaLiberacion($jsonData->fechaLiberacion);
        $OrdenesDeCompra->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($OrdenesDeCompra);
        $this->entityManager->flush();
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