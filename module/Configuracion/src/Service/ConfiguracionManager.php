<?php

namespace Configuracion\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;
use DBAL\Entity\Usuarios;
use DBAL\Entity\NotificacionesXPerfil;
use DBAL\Entity\Parametros;

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

        $NotificacionesXPerfil->setTipoEvento($TipoEvento);
        $NotificacionesXPerfil->setPerfil($Perfil);

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
        $YaCargados = [];
        
        foreach($JsonData->arrNotificacionesXPerfil as $NotificacionXPerfil){
            $TipoEvento = $this->catalogoManager->getTiposEvento($NotificacionXPerfil->tipoEvento->id);
            $Perfil = $this->catalogoManager->getPerfiles($NotificacionXPerfil->perfil->id);
            //Compruebo si ya existe una entidad NotificacionesXPerfil para ese perfil y tipoEvento
            $NotificacionesXPerfil = $this->catalogoManager->getNotificacionesXPerfilPorTipoEventoPerfil($TipoEvento, $Perfil);

            if (!isset($NotificacionesXPerfil)){
                $this->crearNotificacionesXPerfiles($TipoEvento, $Perfil);
            }else{
                // Si ya existe, la quito del arreglo $NotificacionesXPerfilesOriginal
                for ($i = 0; $i < count($NotificacionesXPerfilesOriginal); $i++){
                    if (array_key_exists($i, $NotificacionesXPerfilesOriginal) 
                        && $NotificacionesXPerfilesOriginal[$i]->getId() == $NotificacionesXPerfil->getId()){
                        $YaCargados[] = $i;
                        break;
                    }
                }
            }
        }

        // Borro las notificaciones originales que quedaron dentro del arreglo $NotificacionesXPerfilesOriginal
        foreach($NotificacionesXPerfilesOriginal as $key => $NotificacionXPerfilesOriginal){
            
            if (!in_array($key, $YaCargados)){
                $this->borrarNotificacionesXPerfiles($NotificacionXPerfilesOriginal);
            } 
        }
    }

    public function altaEdicionParametros($jsonData, $idParametros = null){
        if ($idParametros){
            $Parametros = $this->catalogoManager->getParametros($idParametros);
        }else{
            $Parametros = new Parametros();
        }

        $Parametros->setParametro($jsonData->nombre);
        $Parametros->setValor($jsonData->valor);
        $Parametros->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Parametros);
        $this->entityManager->flush();
    }

    public function borrarParametros($idParametros){
        $Parametros = $this->catalogoManager->getParametros($idParametros);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Parametros);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el parametro correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El parametro no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}
