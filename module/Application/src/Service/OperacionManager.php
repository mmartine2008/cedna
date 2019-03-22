<?php

namespace Application\Service;

use DBAL\Entity\Operacion;

class OperacionManager {
    
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
     * Recupera el listado completo de las entidades Operacion.
     *
     * @return array
     */
    public function getListado(){
        $arrOperaciones = $this->entityManager->getRepository(Operacion::class)->findAll();
        
        return $arrOperaciones;
    }

    /**
     * Busca una entidad Operacion por su id.
     *
     * @param [integer] $idOperacion
     * @return Operacion
     */
    public function getEntidadPorId($idOperacion){
        $Operacion = $this->entityManager->getRepository(Operacion::class)->findOneBy(['id' => $idOperacion]);
        
        return $Operacion;
    }

    /**
     * Procesa el alta de una nueva entidad Operacion.
     *
     * @param [JSON] $jsonData
     * @return void
     */
    public function procesarAlta($jsonData, $idOperacion = null){
        if ($idOperacion){
            $Operacion = $this->getEntidadPorId($idOperacion);
        }else{
            $Operacion = new Operacion();
        }
        
        $Operacion->setNombre($jsonData->nombre);
        $Operacion->setTitulo($jsonData->titulo);
        $Operacion->setIcono($jsonData->icono);

        if (trim($jsonData->id_grupo) != ''){
            $EntidadPadre = $this->getEntidadPorId($jsonData->id_grupo);
            $Operacion->setGrupo($EntidadPadre);
        }
        
        $Operacion->setOrden($jsonData->orden);

        if (trim($jsonData->url) != ''){
            $Operacion->setUrl($jsonData->url);
        }

        $this->entityManager->persist($Operacion);
        $this->entityManager->flush();
    }

    /**
     * Funcion que retorna un arreglo con todas las variables
     * necesarias en el template de alta de la entidad.
     *
     * @return array
     */
    public function getArrVariablesAltaEntidad(){
        $Operaciones = $this->getListado();

        return [
            'Operaciones' => $Operaciones
        ];
    }

    public function borrarEntidad($idOperacion){
        $Operacion = $this->getEntidadPorId($idOperacion);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Operacion);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la operación correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La operación no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}