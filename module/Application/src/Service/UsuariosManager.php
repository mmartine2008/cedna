<?php

namespace Application\Service;

use DBAL\Entity\Usuarios;

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
    public function procesarAlta($jsonData){
        $Usuario = new Usuarios();

        $Usuario->setNombreUsuario($jsonData->username);
        $Usuario->setClave($jsonData->clave);
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
}