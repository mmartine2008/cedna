<?php

namespace Application\Service;

use DBAL\Entity\Nodos;

class OrganigramaManager {
    
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

    public function altaEdicionNodos($jsonData, $idNodos = null){
        if ($idNodos){
            $Nodos = $this->catalogoManager->getNodos($idNodos);
        }else{
            $Nodos = new Nodos();
        }
        $Nodos->setNombre($jsonData->nombre);
        
        $TipoNodo = $this->catalogoManager->getTipoNodo($jsonData->idTipoNodo);
        $Nodos->setTipoNodo($TipoNodo);

        if ($jsonData->idNodoSuperior != ''){
            $NodoSuperior = $this->catalogoManager->getNodos($jsonData->idNodoSuperior);
            $Nodos->setNodoSuperior($NodoSuperior);
        }
        
        $this->entityManager->persist($Nodos);
        $this->entityManager->flush();
    }
    
    public function borrarNodos($idNodos){
        $Nodos = $this->catalogoManager->getNodos($idNodos);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Nodos);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el nodo correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El nodo no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}