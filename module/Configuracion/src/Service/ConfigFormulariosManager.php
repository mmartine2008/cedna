<?php

namespace Configuracion\Service;

class ConfigFormulariosManager{
    
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
    public function altaEdicionFormularios($jsonData, $idParametros = null){
        if ($idParametros){
            $Parametros = $this->catalogoManager->getParametros($idParametros);
        }else{
            $Parametros = new Parametros();
        }

        $Parametros->setParametro($jsonData->nombre);
        $Parametros->setValor($jsonData->valor);
        $Parametros->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Parametros);
        $this->entityManager->flush();
    }

    public function borrarFormularios($idParametros){
        $Parametros = $this->catalogoManager->getParametros($idParametros);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Parametros);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el parametro correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El parametro no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
    
}