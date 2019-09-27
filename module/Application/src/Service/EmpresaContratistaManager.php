<?php

namespace Application\Service;

use DBAL\Entity\EmpresasContratistas;

use Matrix\Exception;

class EmpresaContratistaManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    private $catalogoManager;
    // private $mailManager;

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
    }

    public function altaEdicionEmpresaContratista($jsonData, $idEmpresaContratista = null){
        if ($idEmpresaContratista){
            $EmpresaContratista = $this->catalogoManager->getEmpresasContratistas($idEmpresaContratista);
        }else{
            $EmpresaContratista = new EmpresasContratistas();
        }
        
        $EmpresaContratista->setRazonSocial($jsonData->razonSocial);
        $EmpresaContratista->setDireccion($jsonData->direccion);
        $EmpresaContratista->setTelefono($jsonData->telefono);

        $this->entityManager->persist($EmpresaContratista);
        $this->entityManager->flush();
    }
    
    public function borrarEmpresaContratista($idEmpresaContratista){
        $EmpresaContratista = $this->catalogoManager->getEmpresasContratistas($idEmpresaContratista);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($EmpresaContratista);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la empresa contratista correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La empresa contratista no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}