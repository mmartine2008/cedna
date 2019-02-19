<?php

namespace Application\Service;

use DBAL\Entity\Perfiles;

class PerfilesManager {
    
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
     * Recupera el listado completo de las entidades Perfiles.
     *
     * @return array
     */
    public function getListado(){
        $arrPerfiles = $this->entityManager->getRepository(Perfiles::class)->findAll();
        
        return $arrPerfiles;
    }

    /**
     * Busca una entidad Perfiles por su id.
     *
     * @param [integer] $idPerfiles
     * @return Perfiles
     */
    public function getEntidadPorId($idPerfiles){
        $Perfil = $this->entityManager->getRepository(Perfiles::class)->findOneBy(['id' => $idPerfiles]);
        
        return $Perfil;
    }

    /**
     * Procesa el alta de una nueva entidad Perfiles.
     *
     * @param [JSON] $jsonData
     * @return void
     */
    public function procesarAlta($jsonData){
        $Perfil = new Perfiles();

        $Perfil->setNombre($jsonData->nombre);
        $Perfil->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Perfil);
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

    public function borrarEntidad($idPerfiles){
        $Perfil = $this->getEntidadPorId($idPerfiles);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Perfil);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el perfil correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El perfil no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}