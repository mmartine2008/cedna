<?php

namespace DBAL\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Operacion;
use DBAL\Entity\Perfiles;
use DBAL\Entity\OperacionAccionPerfil;
use DBAL\Entity\Usuarios;
use DBAL\Entity\Operarios;
use DBAL\Entity\TipoNodo;
use DBAL\Entity\Nodos;
use DBAL\Entity\TipoJefe;
use DBAL\Entity\esJefeDe;

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

    public function getOperarios($idOperarios = null){
        if ($idOperarios){
            $Operarios = $this->entityManager->getRepository(Operarios::class)->findOneBy(['id' => $idOperarios]);
        }else{
            $Operarios = $this->entityManager->getRepository(Operarios::class)->findAll();
        }

        return $Operarios;
    }

    public function getTipoNodo($idTipoNodo = null){
        if ($idTipoNodo){
            $TipoNodo = $this->entityManager->getRepository(TipoNodo::class)->findOneBy(['id' => $idTipoNodo]);
        }else{
            $TipoNodo = $this->entityManager->getRepository(TipoNodo::class)->findAll();
        }

        return $TipoNodo;
    }

    public function getNodos($idNodos = null){
        if ($idNodos){
            $Nodos = $this->entityManager->getRepository(Nodos::class)->findOneBy(['id' => $idNodos]);
        }else{
            $Nodos = $this->entityManager->getRepository(Nodos::class)->findAll();
        }

        return $Nodos;
    }

    public function getTipoJefe($idTipoJefe = null){
        if ($idTipoJefe){
            $TipoJefe = $this->entityManager->getRepository(TipoJefe::class)->findOneBy(['id' => $idTipoJefe]);
        }else{
            $TipoJefe = $this->entityManager->getRepository(TipoJefe::class)->findAll();
        }

        return $TipoJefe;
    }

    public function getEsJefeDePorNodoUsuario($Nodo, $Usuario){
        $EsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findOneBy(['Nodo' => $Nodo, 'Usuario' => $Usuario]);

        return $EsJefeDe;
    }

    public function getEsJefeDePorNodo($Nodo){
        $arrEsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findBy(['Nodo' => $Nodo]);

        return $arrEsJefeDe;
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades Operarios
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrOperariosJSON(){
        $arrOperarios = $this->getOperarios();

        $output = [];
        
        foreach($arrOperarios as $Operario){
            $output[] = $Operario->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades Nodos
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrNodosJSON(){
        $arrNodos = $this->getNodos();

        $output = [];
        
        foreach($arrNodos as $Nodo){
            $output[] = $Nodo->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades Usuarios
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrUsuariosJSON(){
        $arrUsuarios = $this->getUsuarios();

        $output = [];
        
        foreach($arrUsuarios as $Usuario){
            $output[] = $Usuario->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades TipoJefe
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrTipoJefeJSON(){
        $arrTipoJefe = $this->getTipoJefe();

        $output = [];
        
        foreach($arrTipoJefe as $TipoJefe){
            $output[] = $TipoJefe->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que recupera las Operaciones iniciales para un determinado perfil.
     * 
     * Se consideran Operaciones iniciales a aquellas operaciones que tienen como
     * operacion padre al INDEX.
     *
     * @param [Perfil] $Perfil
     * @param [string] $nombreOperacion
     * @return void
     */
    public function getOperacionesInicialesPorPerfil($Perfil, $nombreOperacion){
        $arrOperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findBy(['Perfil' => $Perfil]);

        $output = [];
        $idsGuardados = [];
        foreach($arrOperacionAccionPerfil as $OperacionAccionPerfil){
            $OperacionIndex = $this->entityManager->getRepository(Operacion::class)->findOneBy(['nombre' => $nombreOperacion]);

            if ($OperacionAccionPerfil->getOperacion()->getGrupo() == $OperacionIndex
                && !in_array($OperacionAccionPerfil->getOperacion()->getId(), $idsGuardados)){
                $output[] = $OperacionAccionPerfil->getOperacion();
                $idsGuardados[] = $OperacionAccionPerfil->getOperacion()->getId();
            }
        }

        return $output;
    }
}