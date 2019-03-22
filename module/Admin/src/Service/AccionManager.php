<?php

namespace Admin\Service;

use DBAL\Entity\Accion;

class AccionManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
        
    }

    /**
     * Recupera el listado completo de las entidades Accion.
     *
     * @return array
     */
    public function getListado(){
        $arrAcciones = $this->entityManager->getRepository(Accion::class)->findAll();
        
        return $arrAcciones;
    }

    /**
     * Busca una entidad Accion por su id.
     *
     * @param [integer] $idAccion
     * @return Accion
     */
    public function getEntidadPorId($idAccion){
        $Accion = $this->entityManager->getRepository(Accion::class)->findOneBy(['id' => $idAccion]);
        
        return $Accion;
    }

    /**
     * Procesa el alta de una nueva entidad Accion.
     *
     * @param [JSON] $jsonData
     * @return void
     */
    public function procesarAlta($jsonData, $idAccion = null){
        if ($idAccion){
            $Accion = $this->getEntidadPorId($idAccion);
        }else{
            $Accion = new Accion();
        }
        
        $Accion->setNombre($jsonData->nombre);
        $Accion->setTitulo($jsonData->titulo);
        $Accion->setIcono($jsonData->icono);

        $this->entityManager->persist($Accion);
        $this->entityManager->flush();
    }

    /**
     * Funcion que retorna un arreglo con todas las variables
     * necesarias en el template de alta de la entidad.
     *
     * @return array
     */
    public function getArrVariablesAltaEntidad(){
        return [];
    }

    public function borrarEntidad($idAccion){
        $Accion = $this->getEntidadPorId($idAccion);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Accion);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la acción correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La acción no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}