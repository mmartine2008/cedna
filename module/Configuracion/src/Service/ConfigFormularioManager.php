<?php

namespace Configuracion\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Seccion;

class ConfigFormularioManager{
    
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

    public function altaEdicionFormularios($jsonData, $idFormulario = null){
        if ($idFormulario){
            $Formulario = $this->catalogoManager->getFormulario($idFormulario);
        }else{
            $Formulario = new Formulario();
        }

        $Formulario->setNombre($jsonData->nombre);
        $Formulario->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Formulario);
        $this->entityManager->flush();
    }

    public function borrarFormularios($idFormulario){
        $Formulario = $this->catalogoManager->getFormulario($idFormulario);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Formulario);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el parametro correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El parametro no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
    
    public function altaSecciones($jsonData, $idFormulario){
        $Seccion = new Seccion();
        $Formulario = $this->catalogoManager->getFormularios($idFormulario);
        $Seccion->setFormulario($Formulario);
        $Seccion->setNombre($jsonData->nombre);
        $Seccion->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Seccion);
        $this->entityManager->flush();
    }

    public function edicionSecciones($jsonData, $idSeccion){
        $Seccion = $this->catalogoManager->getSeccion($idSeccion);
        $Seccion->setNombre($jsonData->nombre);
        $Seccion->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($Seccion);
        $this->entityManager->flush();
    }
}