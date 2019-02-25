<?php

namespace Configuracion\Service;

use Zend\Crypt\Password\Bcrypt;

use DBAL\Entity\Perfiles;
use DBAL\Entity\Usuarios;
use DBAL\Entity\UsuariosxPerfiles;

class ConfigUsuariosManager {
    
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

    public function altaEdicionUsuarios($jsonData, $idUsuarios = null){
        if ($idUsuarios){
            $Usuarios = $this->catalogoManager->getUsuarios($idUsuarios);
        }else{
            $Usuarios = new Usuarios();
        }

        $Usuarios->setNombreUsuario($jsonData->username);
        $Usuarios->setNombre($jsonData->nombre);
        $Usuarios->setApellido($jsonData->apellido);
        $Usuarios->setEmail($jsonData->email);

        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($jsonData->clave);
        $Usuarios->setClave($passwordHash);

        $Usuarios->setFechaAlta(new \DateTime('now'));

        $this->actualizarPerfiles($Usuarios, $jsonData->perfiles);

        $this->entityManager->persist($Usuarios);
        $this->entityManager->flush();
    }

    public function borrarUsuarios($idUsuarios){
        $Usuarios = $this->catalogoManager->getUsuarios($idUsuarios);

        $this->entityManager->beginTransaction();         
        try {
            $Usuarios->removeAllPerfiles();
            
            $this->entityManager->remove($Usuarios);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el usuario correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El usuario no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

    /**
     * Funcion que recibe un arreglo de perfiles que hay que eliminar de un usuario.
     *
     * @param [Usuarios] $Usuarios
     * @param [array] $arrPerfilesOriginales
     * @return void
     */
    private function borrarPerfilesFromArreglo($Usuarios, $arrPerfilesOriginales){
        foreach($arrPerfilesOriginales as $PerfilOriginal){
            $UsuarioxPerfil = $this->entityManager->getRepository(UsuariosxPerfiles::class)
                                                        ->findOneBy(['Usuario' => $Usuarios, 'Perfil' => $PerfilOriginal]);
            $this->entityManager->beginTransaction();         
            try {
                $this->entityManager->remove($UsuarioxPerfil);
                $this->entityManager->flush();
    
                $this->entityManager->commit();
            } catch (Exception $e) {
                $this->entityManager->rollBack();
            }
        }
    }

    /**
     * Funcion que recibe un arreglo de perfiles a asignar al usuario.
     * 
     * Controla que el perfil no este anteriormente asignado y si
     * hay que elimnar perfiles originales.
     *
     * @param [Usuarios] $Usuarios
     * @param [array] $arrPerfiles
     * @return void
     */
    private function actualizarPerfiles($Usuarios, $arrPerfiles){
        $arrPerfilesOriginales = $Usuarios->getPerfiles();

        foreach($arrPerfiles as $perfil){
            $Perfil = $this->catalogoManager->getPerfiles($perfil->id);

            $asignadoAnteriormente = false;

            for ($i = 0; $i < count($arrPerfilesOriginales); $i++){
                if ($arrPerfilesOriginales[$i] == $Perfil){
                    unset($arrPerfilesOriginales[$i]);
                    $asignadoAnteriormente = true;
                    break;
                }
            }

            if (!$asignadoAnteriormente){
                $Usuarios->addPerfil($Perfil);
            }
        }

        //Los perfiles que quedaron en el arreglo origen, son perfiles q hay q eliminar
        $this->borrarPerfilesFromArreglo($Usuarios, $arrPerfilesOriginales);
    }
    
    /**
     * Funcion que devuelve el arreglo de todas las entidades Usuarios
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrUsuariosJSON(){
        $arrUsuarios = $this->catalogoManager->getUsuarios();

        $output = [];
        
        foreach($arrUsuarios as $Usuario){
            $output[] = $Usuario->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }
}