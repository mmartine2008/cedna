<?php

namespace Admin\Service;

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
    public function procesarAlta($jsonData, $idOperacionAccionPerfil = null){
        if ($idOperacionAccionPerfil){
            $OperacionAccionPerfil = $this->getEntidadPorId($idOperacionAccionPerfil);
        }else{
            $OperacionAccionPerfil = new OperacionAccionPerfil();
        }

        $Operacion = $this->operacionManager->getEntidadPorId($jsonData->idOperacion);
        $Accion = $this->accionManager->getEntidadPorId($jsonData->idAccion);
        $Perfil = $this->perfilesManager->getEntidadPorId($jsonData->idPerfil);

        $OperacionAccionPerfil->setOperacion($Operacion);
        $OperacionAccionPerfil->setAccion($Accion);
        $OperacionAccionPerfil->setPerfil($Perfil);
        $OperacionAccionPerfil->setUrlDestino($jsonData->urlDestino);
        $OperacionAccionPerfil->setOrdenUbicacion($jsonData->ordenUbicacion);
        $OperacionAccionPerfil->setJsFunction($jsonData->jsFunction);
        $OperacionAccionPerfil->setIdHTMLElement($jsonData->idHTMLElement);

        $this->entityManager->persist($OperacionAccionPerfil);
        $this->entityManager->flush();
    }

    /**
     * Funcion que retorna un arreglo con todas las variables
     * necesarias en el template de alta de la entidad.
     *
     * Listo al reves las operaciones, para que a la hora de buscar una
     * operacion recien agregada no tenga q ir hasta el final.
     * 
     * @return array
     */
    public function getArrVariablesAltaEntidad(){
        $OperacionesAlReves = array_reverse($this->operacionManager->getListado());
        return [
            'Acciones' => $this->accionManager->getListado(),
            'Operaciones' => $OperacionesAlReves,
            'Perfiles' => $this->perfilesManager->getListado()
        ];
    }

    public function borrarEntidad($idOperacionAccionPerfil){
        $OperacionAccionPerfil = $this->getEntidadPorId($idOperacionAccionPerfil);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($OperacionAccionPerfil);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la relación correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La relación no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}