<?php

namespace Admin\Service;

use DBAL\Entity\TipoPregunta;

class TipoPreguntaManager {
    
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
     * Busca una entidad TipoPregunta por su id.
     *
     * @param [integer] $idTipoPregunta
     * @return TipoPregunta
     */
    public function getEntidadPorId($idTipoPregunta){
        $TipoPregunta = $this->entityManager->getRepository(TipoPregunta::class)->findOneBy(['id' => $idTipoPregunta]);
        
        return $TipoPregunta;
    }

    public function altaEdicionTipoPregunta($jsonData, $idTipoPregunta = null){
        if ($idTipoPregunta){
            $TipoPregunta = $this->getEntidadPorId($idTipoPregunta);
        }else{
            $TipoPregunta = new TipoPregunta();
        }

        $TipoPregunta->setDescripcion($jsonData->descripcion);
        $TipoPregunta->setCantDestinos($jsonData->cantDestinos);

        $this->entityManager->persist($TipoPregunta);
        $this->entityManager->flush();
    }

    public function borrarTipoPregunta($idTipoPregunta){
        $TipoPregunta = $this->getEntidadPorId($idTipoPregunta);

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
}