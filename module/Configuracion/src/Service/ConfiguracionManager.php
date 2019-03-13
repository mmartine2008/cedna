<?php

namespace Configuracion\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;
use DBAL\Entity\Usuarios;
use DBAL\Entity\NotificacionesXPerfil;

class ConfiguracionManager {
    
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

    public function altaEdicionTipoPregunta($jsonData, $idTipoPregunta = null){
        if ($idTipoPregunta){
            $TipoPregunta = $this->catalogoManager->getTipoPregunta($idTipoPregunta);
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
            $Perfiles = $this->catalogoManager->getPerfiles($idPerfiles);
        }else{
            $Perfiles = new Perfiles();
        }

        $Perfiles->setNombre($jsonData->nombre);
        $Perfiles->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Perfiles);
        $this->entityManager->flush();
    }

    public function borrarTipoPregunta($idTipoPregunta){
        $TipoPregunta = $this->catalogoManager->getTipoPregunta($idTipoPregunta);

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
        $Perfiles = $this->catalogoManager->getPerfiles($idPerfiles);

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

    private function crearNotificacionesXPerfiles($TipoEvento, $Perfil){
        $NotificacionesXPerfil = new NotificacionesXPerfil();

        $NotificacionesXPerfil->setTipoEvento($Perfil);
        $NotificacionesXPerfil->setPerfil($TipoEvento);

        $this->entityManager->persist($NotificacionesXPerfil);
        $this->entityManager->flush();
    }

    private function borrarNotificacionesXPerfiles($NotificacionXPerfilesOriginal){
        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($NotificacionXPerfilesOriginal);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollBack();
        }
    }

    public function guardarNotificacionesXPerfiles($JsonData){
        $NotificacionesXPerfilesOriginal = $this->catalogoManager->getNotificacionesXPerfil();

        foreach($JsonData->arrNotificacionesXPerfil as $NotificacionXPerfil){
            $TipoEvento = $this->catalogoManager->getTiposEvento($NotificacionXPerfil->tipoEvento->id);
            $Perfil = $this->catalogoManager->getPerfiles($NotificacionXPerfil->perfil->id);
            //Compruebo si ya existe una entidad NotificacionesXPerfil para ese perfil y tipoEvento
            $NotificacionesXPerfil = $this->catalogoManager->getNotificacionesXPerfilPorTipoEventoPerfil($TipoEvento, $Perfil);

            if (!isset($NotificacionesXPerfil)){
                $this->crearNotificacionesXPerfiles($TipoEvento, $Perfil);
            }else{
                //Si ya existe, la quito del arreglo $NotificacionesXPerfilesOriginal
                for ($i = 0; $i < count($NotificacionesXPerfilesOriginal); $i){
                    if ($NotificacionesXPerfilesOriginal[$i]->getId() == $NotificacionesXPerfil->getId()){
                        unset($NotificacionesXPerfilesOriginal[$i]);
                        break;
                    }
                }
            }
        }

        //Borro las notificaciones originales que quedaron dentro del arreglo $NotificacionesXPerfilesOriginal
        foreach($NotificacionesXPerfilesOriginal as $NotificacionXPerfilesOriginal){
            $this->borrarNotificacionesXPerfiles($NotificacionXPerfilesOriginal);
        }
    }
}