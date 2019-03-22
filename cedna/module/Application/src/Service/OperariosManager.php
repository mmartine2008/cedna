<?php

namespace Application\Service;

use DBAL\Entity\Operarios;

class OperariosManager {
    
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

    public function altaEdicionOperarios($jsonData, $idOperarios = null){
        if ($idOperarios){
            $Operarios = $this->catalogoManager->getOperarios($idOperarios);
        }else{
            $Operarios = new Operarios();
        }

        $Operarios->setNombre($jsonData->nombre);
        $Operarios->setApellido($jsonData->apellido);
        $Operarios->setCuit($jsonData->cuit);
        $Operarios->setTelefono($jsonData->telefono);
        $Operarios->setEmail($jsonData->email);

        $this->entityManager->persist($Operarios);
        $this->entityManager->flush();

        if ($idOperarios){
            $this->mailManager->notificarEdicionDeOperario($Operarios);
        }else{
            $this->mailManager->notificarAltaDeOperario($Operarios);
        }
    }
    
    public function borrarOperarios($idOperarios){
        $Operarios = $this->catalogoManager->getOperarios($idOperarios);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Operarios);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el operario correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El operario no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}