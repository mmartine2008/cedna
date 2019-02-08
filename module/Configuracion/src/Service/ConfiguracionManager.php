<?php

namespace Configuracion\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;

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

        $this->entityManager->persist($TipoPregunta);
        $this->entityManager->flush();
    }
    
}