<?php

namespace Application\Service;

use DBAL\Entity\Nodos;
use DBAL\Entity\esJefeDe;

class OrganigramaManager {
    
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

    public function altaEdicionNodos($jsonData, $idNodos = null){
        if ($idNodos){
            $Nodos = $this->catalogoManager->getNodos($idNodos);
        }else{
            $Nodos = new Nodos();
        }
        $Nodos->setNombre($jsonData->nombre);
        
        $TipoNodo = $this->catalogoManager->getTipoNodo($jsonData->idTipoNodo);
        $Nodos->setTipoNodo($TipoNodo);

        if ($jsonData->idNodoSuperior != ''){
            $NodoSuperior = $this->catalogoManager->getNodos($jsonData->idNodoSuperior);
            $Nodos->setNodoSuperior($NodoSuperior);
        }
        
        $this->entityManager->persist($Nodos);
        $this->entityManager->flush();
    }

    private function eliminarJefeDelArregloInicial($arrJefesIniciales, $Usuario){
        $output = [];

        foreach($arrJefesIniciales as $Jefe){
            if ($Jefe->getId() != $Usuario->getId()){
                $output[] = $Jefe;
            }
        }

        return $output;
    }

    public function altaEdicionAutoridades($jsonData, $Nodos){
        $arrJefesIniciales = $Nodos->getJefes();

        foreach($jsonData as $jefe){
            $Usuario = $this->catalogoManager->getUsuarios($jefe->usuario->id);
            $TipoJefe = $this->catalogoManager->getTipoJefe($jefe->tipoJefe->id);
            $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodos, $Usuario);

            if (!isset($esJefeDe)){
                $esJefeDe = new esJefeDe();

                $esJefeDe->setNodo($Nodos);
                $esJefeDe->setUsuario($Usuario);
            }
            $esJefeDe->setTipoJefe($TipoJefe);
            $esJefeDe->setOrden($jefe->orden);

            $this->entityManager->persist($esJefeDe);
            $arrJefesIniciales = $this->eliminarJefeDelArregloInicial($arrJefesIniciales, $Usuario);
        }
        
        $this->entityManager->flush();

        foreach($arrJefesIniciales as $Jefe){
            $this->borrarJefeDelNodo($Nodos, $Jefe);
        }
    }

    public function getUsuariosDisponiblesParaJefe($Nodo){
        $arrJefesIniciales = $Nodo->getJefes();
        $arrUsuariosString  = $this->catalogoManager->getArrEntidadJSON('Usuarios');
        $arrUsuariosJSON = json_decode($arrUsuariosString);
        $output = [];

        foreach($arrUsuariosJSON as $UsuarioJSON){
            $existe = false;
            foreach($arrJefesIniciales as $Jefe){
                if ($Jefe->getId() == $UsuarioJSON->id){
                    $existe = true;
                }
            }

            if (!$existe){
                $output[] = $UsuarioJSON;
            }
        }

        return json_encode($output);
    }

    private function borrarJefeDelNodo($Nodos, $Jefe){
        $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodos, $Jefe);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($esJefeDe);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollBack();
        }
    }
    
    public function borrarNodos($idNodos){
        $Nodos = $this->catalogoManager->getNodos($idNodos);

        $this->entityManager->beginTransaction();         
        try {
            $this->entityManager->remove($Nodos);
            $this->entityManager->flush();

            $this->entityManager->commit();
            $mensaje = 'Se ha eliminado el nodo correctamente';

        } catch (Exception $e) {
            $this->entityManager->rollBack();

            $mensaje = 'El nodo no se ha podido eliminar, posiblemente este siendo referenciado por otra entidad';
        }

        return $mensaje;
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades esJefeDe
     * de un Nodo especifico en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrJefesInicialesJSON($Nodo){
        $arrEsJefeDe = $this->catalogoManager->getEsJefeDePorNodo($Nodo);

        $output = [];
        
        foreach($arrEsJefeDe as $esJefeDe){
            $output[] = $esJefeDe->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }
}