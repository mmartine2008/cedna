<?php

namespace Application\Service;

use DBAL\Entity\HerramientasDeTrabajo;

class HerramientasManager {
    
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

    public function altaEdicionHerramientas($jsonData, $idHerramientas = null){
        if ($idHerramientas){
            $Herramientas = $this->catalogoManager->getHerramientasDeTrabajo($idHerramientas);
        }else{            
            $Herramientas = new HerramientasDeTrabajo();
        }
        $Herramientas->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Herramientas);
        $this->entityManager->flush();
    }

    
    public function borrarHerramientas($idHerramientas){
        $Herramientas = $this->catalogoManager->getHerramientasDeTrabajo($idHerramientas);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Herramientas);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la Herramienta correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La Herramienta no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

}