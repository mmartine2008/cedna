<?php

namespace DBAL\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;
use DBAL\Entity\Usuarios;

class CatalogoManager {
    
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

    public function getAccionesPorPerfil($OperacionNombre, $Perfil){
        $Operacion = $this->entityManager->getRepository(Operacion::class)->findOneBy(['nombre' => $OperacionNombre]);

        $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findBy(['Operacion' => $Operacion, 'Perfil' => $Perfil]);

        return $OperacionAccionPerfil;
    }

    public function getUsuarios($idUsuarios = null){
        if ($idUsuarios){
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['id' => $idUsuarios]);
        }else{
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findAll();
        }

        return $Usuarios;
    }

    /**
     * Funcion que recupera las Operaciones iniciales para un determinado perfil.
     * 
     * Se consideran Operaciones iniciales a aquellas operaciones que tienen como
     * operacion padre al INDEX.
     *
     * @param [type] $Perfil
     * @return void
     */
    public function getOperacionesInicialesPorPerfil($Perfil){
        $arrOperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findBy(['Perfil' => $Perfil]);

        $output = [];
        $idsGuardados = [];
        foreach($arrOperacionAccionPerfil as $OperacionAccionPerfil){
            $OperacionIndex = $this->entityManager->getRepository(Operacion::class)->findOneBy(['nombre' => Operacion::NOMBRE_INDEX]);

            if ($OperacionAccionPerfil->getOperacion()->getGrupo() == $OperacionIndex
                && !in_array($OperacionAccionPerfil->getOperacion()->getId(), $idsGuardados)){
                $output[] = $OperacionAccionPerfil->getOperacion();
                $idsGuardados[] = $OperacionAccionPerfil->getOperacion()->getId();
            }
        }

        return $output;
    }
}