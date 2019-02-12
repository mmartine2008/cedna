<?php

namespace Configuracion\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;
use DBAL\Entity\Usuarios;

class ConfiguracionManager {
    
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

    public function getTipoPregunta($idTipoPregunta = null){
        if ($idTipoPregunta){
            $TipoPregunta = $this->entityManager->getRepository(TipoPregunta::class)->findOneBy(['id' => $idTipoPregunta]);
        }else{
            $TipoPregunta = $this->entityManager->getRepository(TipoPregunta::class)->findAll();
        }

        return $TipoPregunta;
    }

    public function getPerfiles($idPerfil = null){
        if ($idPerfil){
            $Perfiles = $this->entityManager->getRepository(Perfiles::class)->findOneBy(['id' => $idPerfil]);
        }else{
            $Perfiles = $this->entityManager->getRepository(Perfiles::class)->findAll();
        }

        return $Perfiles;
    }

    public function getUsuarios($idUsuarios = null){
        if ($idUsuarios){
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['id' => $idUsuarios]);
        }else{
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        }

        return $Usuarios;
    }

    public function getAccionesPorPerfil($OperacionNombre, $PerfilNombre){
        $Perfil = $this->entityManager->getRepository(Perfiles::class)->findOneBy(['Nombre' => $PerfilNombre]);

        $Operacion = $this->entityManager->getRepository(Operacion::class)->findOneBy(['nombre' => $OperacionNombre]);

        $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findBy(['Operacion' => $Operacion, 'Perfil' => $Perfil]);

        return $OperacionAccionPerfil;
    }

    public function altaEdicionTipoPregunta($jsonData, $idTipoPregunta = null){
        if ($idTipoPregunta){
            $TipoPregunta = $this->getTipoPregunta($idTipoPregunta);
        }else{
            $TipoPregunta = new TipoPregunta();
        }

        $TipoPregunta->setDescripcion($jsonData->descripcion);
        $TipoPregunta->setCantDestinos($jsonData->cantDestinos);

        $this->entityManager->persist($TipoPregunta);
        $this->entityManager->flush();
    }

    public function altaEdicionPerfiles($jsonData, $idPerfiles = null){
        if ($idPerfiles){
            $Perfiles = $this->getPerfiles($idPerfiles);
        }else{
            $Perfiles = new Perfiles();
        }

        $Perfiles->setNombre($jsonData->nombre);
        $Perfiles->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Perfiles);
        $this->entityManager->flush();
    }

    public function altaEdicionUsuarios($jsonData, $idUsuarios = null){
        if ($idUsuarios){
            $Usuarios = $this->getUsuarios($idUsuarios);
        }else{
            $Usuarios = new Usuarios();
        }

        $Usuarios->setNombreUsuario($jsonData->username);
        $Usuarios->setNombre($jsonData->nombre);
        $Usuarios->setApellido($jsonData->apellido);
        $Usuarios->setEmail($jsonData->email);
        $Usuarios->setClave($jsonData->clave);
        $Usuarios->setFechaAlta(new \DateTime('now'));

        $this->entityManager->persist($Usuarios);
        $this->entityManager->flush();
    }

    public function borrarTipoPregunta($idTipoPregunta){
        $TipoPregunta = $this->getTipoPregunta($idTipoPregunta);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($TipoPregunta);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el tipo de pregunta correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El tipo de pregunta no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

    public function borrarPerfiles($idPerfiles){
        $Perfiles = $this->getPerfiles($idPerfiles);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Perfiles);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el perfil correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El perfil no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

    public function borrarUsuarios($idUsuarios){
        $Usuarios = $this->getUsuarios($idUsuarios);

        $this->entityManager->beginTransaction();         
        try {
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
    
}