<?php

namespace Application\Service;

use DBAL\Entity\OperacionAccionPerfil;

class OperacionAccionPerfilManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 

    private $accionManager;
    private $operacionManager;
    private $perfilesManager;
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $accionManager, $operacionManager, $perfilesManager) 
    {
        $this->entityManager = $entityManager;
        $this->accionManager = $accionManager;
        $this->operacionManager = $operacionManager;
        $this->perfilesManager = $perfilesManager;
    }

    /**
     * Recupera el listado completo de las entidades OperacionAccionPerfil.
     *
     * @return array
     */
    public function getListado(){
        $arrOperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)->findAll();
        
        return $arrOperacionAccionPerfil;
    }

    /**
     * Busca una entidad OperacionAccionPerfil por su id.
     *
     * @param [integer] $idOperacionAccionPerfil
     * @return OperacionAccionPerfil
     */
    public function getEntidadPorId($idOperacionAccionPerfil){
        $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findOneBy(['id' => $idOperacionAccionPerfil]);
        
        return $OperacionAccionPerfil;
    }

    /**
     * Procesa el alta de una nueva entidad OperacionAccionPerfil.
     *
     * @param [JSON] $jsonData
     * @return void
     */
    public function procesarAlta($jsonData){
        $OperacionAccionPerfil = new OperacionAccionPerfil();

        $Operacion = $this->operacionManager->getEntidadPorId($jsonData->idOperacion);
        $Accion = $this->accionManager->getEntidadPorId($jsonData->idAccion);
        $Perfil = $this->perfilesManager->getEntidadPorId($jsonData->idPerfil);

        $OperacionAccionPerfil->setOperacion($Operacion);
        $OperacionAccionPerfil->setAccion($Accion);
        $OperacionAccionPerfil->setPerfil($Perfil);
        $OperacionAccionPerfil->setControllerName($jsonData->controllerName);
        $OperacionAccionPerfil->setControllerAction($jsonData->controllerAction);
        $OperacionAccionPerfil->setJsFunction($jsonData->jsFunction);

        $this->entityManager->persist($OperacionAccionPerfil);
        $this->entityManager->flush();
    }

    /**
     * Funcion que retorna un arreglo con todas las variables
     * necesarias en el template de alta de la entidad.
     *
     * @return array
     */
    public function getArrVariablesAltaEntidad(){
        return [
            'Acciones' => $this->accionManager->getListado(),
            'Operaciones' => $this->operacionManager->getListado(),
            'Perfiles' => $this->perfilesManager->getListado()
        ];
    }
}