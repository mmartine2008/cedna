<?php

namespace Application\Service;

use DBAL\Entity\Inducciones;

class InduccionesManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    private $catalogoManager;
    private $mailManager;

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager, $mailManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
        $this->mailManager = $mailManager;
    }

    public function altaEdicionInducciones($jsonData, $idInducciones = null){
        if ($idInducciones){
            $Inducciones = $this->catalogoManager->getInducciones($idInducciones);
        }else{
            $Inducciones = new Inducciones();
        }

        $Inducciones->setFecha($jsonData->fecha);
        $Inducciones->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Inducciones);
        $this->entityManager->flush();

        if ($idInducciones){
            $this->mailManager->notificarEdicionDeInduccion($Inducciones);
        }else{
            $this->mailManager->notificarAltaDeInduccion($Inducciones);
        }
    }
    
    public function borrarInducciones($idInducciones){
        $Inducciones = $this->catalogoManager->getInducciones($idInducciones);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Inducciones);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el induccion correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El induccion no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}