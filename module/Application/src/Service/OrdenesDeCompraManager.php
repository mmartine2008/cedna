<?php

namespace Application\Service;

use DBAL\Entity\OrdenesDeCompra;

class OrdenesDeCompraManager {
    
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

    public function altaEdicionOrdenesDeCompra($jsonData, $idOrdenesDeCompra = null){

        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->idFormulario);

        if ($idOrdenesDeCompra){
            $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);

            $Relevamiento = $OrdenesDeCompra->getRelevamiento();
            $Relevamiento->setFormulario($Formulario);
            $this->entityManager->persist($Relevamiento);
        }else{
            $Relevamiento = new Relevamientos();
            $Relevamiento->setFormulario($Formulario);
            
            $this->entityManager->persist($Relevamiento);
            $this->entityManager->flush();

            $EstadoTarea = $this->catalogoManager->getEstadoTarea(EstadoTarea::ID_ESTADO_SOLICITADA);
            
            $OrdenesDeCompra = new OrdenesDeCompra();

            $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

            $OrdenesDeCompra->setSolicitante($UsuarioActivo);
            $OrdenesDeCompra->setFechaSolicitud(new \DateTime("now"));
            $OrdenesDeCompra->setEstadoTarea($EstadoTarea);
            $OrdenesDeCompra->setRelevamiento($Relevamiento);
        }

        $Nodo = $this->catalogoManager->getNodos($jsonData->nodo->id);
        $Formulario = $this->catalogoManager->getFormulario($jsonData->formulario->idFormulario);

        $OrdenesDeCompra->setNodo($Nodo);
        $OrdenesDeCompra->setResumen($jsonData->resumen);
        $OrdenesDeCompra->setDescripcion($jsonData->descripcion);

        $this->entityManager->persist($OrdenesDeCompra);
        $this->entityManager->flush();
    }
    
    public function borrarOrdenesDeCompra($idOrdenesDeCompra){
        $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($OrdenesDeCompra);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado la tarea correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'La tarea no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }
}