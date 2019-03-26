<?php

namespace Application\Service;

use DBAL\Entity\Operarios;
use DBAL\Entity\InduccionXOperario;

class OperariosManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    private $catalogoManager;
    private $mailManager;

    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager, $mailManager) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
        $this->mailManager = $mailManager;
    }

    public function altaEdicionOperarios($jsonData, $UsuarioActivo, $idOperarios = null){
        if ($idOperarios){
            $Operarios = $this->catalogoManager->getOperarios($idOperarios);
        }else{
            $Operarios = new Operarios();
        }

        $Operarios->setNombre($jsonData->nombre);
        $Operarios->setApellido($jsonData->apellido);
        $Operarios->setCuit($jsonData->cuit);
        $Operarios->setTelefono($jsonData->telefono);
        $Operarios->setEmail($jsonData->email);
        $Operarios->setContratista($UsuarioActivo);

        $this->entityManager->persist($Operarios);
        $this->entityManager->flush();

        if ($idOperarios){
            $this->mailManager->notificarEdicionDeOperario($Operarios);
        }else{
            $this->mailManager->notificarAltaDeOperario($Operarios);
        }
    }
    
    public function borrarOperarios($idOperarios){
        $Operarios = $this->catalogoManager->getOperarios($idOperarios);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Operarios);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el operario correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El operario no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

    public function getArrOperariosJSON($UsuarioActivo){
        $arrOperarios = $this->catalogoManager->getOperariosPorContratista($UsuarioActivo);

        $output = [];
        foreach($arrOperarios as $Operario){
            $output[] = $Operario->getJSON();
        }

        $output = implode(',', $output);

        return '[' . $output . ']';
    }

    public function cargarInduccionesAOperarios($JsonData, $Induccion){
        $this->eliminarOperariosDeLaInduccion($Induccion);

        foreach($JsonData->arrOperarios as $operarioJSON){
            $Operario = $this->catalogoManager->getOperarios($operarioJSON->id);

            $InduccionXOperario = new InduccionXOperario();
            $InduccionXOperario->setInduccion($Induccion);
            $InduccionXOperario->setOperario($Operario);

            $this->entityManager->persist($InduccionXOperario);
        }

        $this->entityManager->flush();
    }

    private function eliminarOperariosDeLaInduccion($Induccion){
        $arrInduccionXOperario = $this->catalogoManager->getInduccionXOperarioPorInduccion($Induccion);

        foreach($arrInduccionXOperario as $InduccionXOperario){
            $this->borrarInduccionXOperario($InduccionXOperario);
        }
    }

    public function borrarInduccionXOperario($InduccionXOperario){
        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($InduccionXOperario);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollBack();
        }
    }
}