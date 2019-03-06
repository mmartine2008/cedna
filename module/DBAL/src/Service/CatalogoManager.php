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
use DBAL\Entity\EstadoTarea;
use DBAL\Entity\Tareas;
use DBAL\Entity\Formulario;
use DBAL\Entity\Relevamientos;
use DBAL\Entity\OrdenesDeCompra;

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

    public function getUsuarioPorNombreUsuario($userName){
        $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['NombreUsuario' => $userName]);

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

    public function getEstadoTarea($idEstadoTarea = null){
        if ($idEstadoTarea){
            $EstadoTarea = $this->entityManager->getRepository(EstadoTarea::class)->findOneBy(['id' => $idEstadoTarea]);
        }else{
            $EstadoTarea = $this->entityManager->getRepository(EstadoTarea::class)->findAll();
        }

        return $EstadoTarea;
    }

    public function getTareas($idTarea = null){
        if ($idTarea){
            $Tareas = $this->entityManager->getRepository(Tareas::class)->findOneBy(['id' => $idTarea]);
        }else{
            $Tareas = $this->entityManager->getRepository(Tareas::class)->findAll();
        }

        return $Tareas;
    }

    public function getFormulario($idFormulario = null){
        if ($idFormulario){
            $Formulario = $this->entityManager->getRepository(Formulario::class)->findOneBy(['id' => $idFormulario]);
        }else{
            $Formulario = $this->entityManager->getRepository(Formulario::class)->findAll();
        }

        return $Formulario;
    }

    public function getEsJefeDePorNodoUsuario($Nodo, $Usuario){
        $EsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findOneBy(['Nodo' => $Nodo, 'Usuario' => $Usuario]);

        return $EsJefeDe;
    }

    public function getEsJefeDePorNodo($Nodo){
        $arrEsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findBy(['Nodo' => $Nodo]);

        return $arrEsJefeDe;
    }

    public function getRelevamientos($idRelevamiento = null){
        if ($idRelevamiento){
            $Relevamientos = $this->entityManager->getRepository(Relevamientos::class)->findOneBy(['id' => $idRelevamiento]);
        }else{
            $Relevamientos = $this->entityManager->getRepository(Relevamientos::class)->findAll();
        }

        return $Relevamientos;
    }

    public function getOrdenesDeCompra($idOrdenesDeCompra = null){
        if ($idOrdenesDeCompra){
            $OrdenesDeCompra = $this->entityManager->getRepository(OrdenesDeCompra::class)->findOneBy(['id' => $idOrdenesDeCompra]);
        }else{
            $OrdenesDeCompra = $this->entityManager->getRepository(OrdenesDeCompra::class)->findAll();
        }

        return $OrdenesDeCompra;
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades OrdenesDeCompra
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrOrdenesDeCompraJSON(){
        $arrOrdenesDeCompra = $this->getOrdenesDeCompra();

        $output = [];
        
        foreach($arrOrdenesDeCompra as $OrdenesDeCompra){
            $output[] = $OrdenesDeCompra->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades Formulario
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrFormularioJSON(){
        $arrFormulario = $this->getFormulario();

        $output = [];
        
        foreach($arrFormulario as $Formulario){
            $output[] = $Formulario->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades EstadoTarea
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrEstadoTareaJSON(){
        $arrEstadoTarea = $this->getEstadoTarea();

        $output = [];
        
        foreach($arrEstadoTarea as $EstadoTarea){
            $output[] = $EstadoTarea->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades Tareas
     * en formato JSON para ser enviado a la vista.
     *
     * @return string
     */
    public function getArrTareasJSON(){
        $arrTareas = $this->getTareas();

        $output = [];
        
        foreach($arrTareas as $Tareas){
            $output[] = $Tareas->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
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

    public function getElementosProteccionPersonal(){
        $resultado = [];
        $elementos = ['Casco', 'Anteojos de Seguridad', 'Antiparras', 'Calzado de seguridad', 'Ropa especial de trabajo', 'Chaleco reflectivo'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getEmpresas() {
        $resultado = [];
        $elementos = ['Construcciones del Sur', 'Construcciones del Norte'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getLugarObra() {
        $resultado = [];
        $elementos = ['Deposito', 'Planta 1', 'Planta 2', 'Zona 1', 'Zona 2'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getEtapasObra() {
        $resultado = [];
        $elementos = ['Pintura', 'Mambo', 'Yeso'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getActividadesObra() {
        $resultado = [];
        $elementos =  ['Pintura', 'Mambo', 'Yeso'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getRiesgosAmbientales() {
        $resultado = [];
        $elementos = ['Existe posibilidad de algún tipo de derrame o emisión?', 'Se colocaron los equipos, elementos o barreras necesarias?'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getRiesgosAdicionales() {
        $resultado = [];
        $elementos = ['Requiere guardia de operación', 'Requiere control de emergencia', 'Requiere guardia de seguridad', 'Requiere equipo contra incendio'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getPruebaDeGases() {
        $resultado = [];
        $elementos = ['LEL, % <= 10', 'O2 % 19.5 a 23', 'CO, ppm <= 35', 'H2S, ppm <= 10'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }

    public function getFirmasPermiso() {
        $resultado = [];
        $elementos = ['Solicitante del trabajo', 'Dueño del área', 'Seguridad e Higiene', 'Contratista'];
        $id = 5;
        foreach($elementos as $elemento){
            $resultado[] = ['id' => "$id", 'descripcion' =>$elemento];
            $id++;
        }
        return $resultado;
    }
}