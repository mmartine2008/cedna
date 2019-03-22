<?php

namespace Application\Service;

use DBAL\Entity\Usuarios;
use Zend\Crypt\Password\Bcrypt;

class UsuariosManager {
    
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
     * Recupera el listado completo de las entidades Usuario.
     *
     * @return array
     */
    public function getListado(){
        $arrUsuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        
        return $arrUsuarios;
    }

    /**
     * Busca una entidad Usuario por su id.
     *
     * @param [integer] $idUsuario
     * @return Usuario
     */
    public function getEntidadPorId($idUsuario){
        $Usuario = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['id' => $idUsuario]);
        
        return $Usuario;
    }

    /**
     * Procesa el alta de una nueva entidad Usuario.
     *
     * @param [JSON] $jsonData
     * @return void
     */
    public function procesarAlta($jsonData, $idUsuario = null){
        if ($idUsuario){
            $Usuario = $this->getEntidadPorId($idUsuario);
        }else{
            $Usuario = new Usuarios();
        }

        $Usuario->setNombreUsuario($jsonData->username);
        
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($jsonData->clave);

        $Usuario->setClave($passwordHash);

        $Usuario->setFechaAlta(new \DateTime('now'));
        $Usuario->setEmail($jsonData->email);
        $Usuario->setNombre($jsonData->nombre);
        $Usuario->setApellido($jsonData->apellido);

        $this->entityManager->persist($Usuario);
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

    public function borrarEntidad($idUsuario){
        $Usuario = $this->getEntidadPorId($idUsuario);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Usuario);
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