<?php

namespace DBAL\Service;

use DBAL\Entity\TipoPregunta;

use DBAL\Entity\Accion;
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
use DBAL\Entity\Relevamientos;
use DBAL\Entity\OrdenesDeCompra;
use DBAL\Entity\Planificaciones;
use DBAL\Entity\TipoPlanificacion;
use DBAL\Entity\TiposEvento;
use DBAL\Entity\NotificacionesXPerfil;
use DBAL\Entity\UsuariosxPerfiles;
use DBAL\Entity\EstadosRelevamiento;
use DBAL\Entity\Inducciones;
use DBAL\Entity\InduccionXOperario;
use DBAL\Entity\LugaresDeObra;
use DBAL\Entity\ElementosProteccionPersonal;
use DBAL\Entity\HerramientasDeTrabajo;
use DBAL\Entity\RiesgosAmbientales;
use DBAL\Entity\RiesgosAdicionales;
use DBAL\Entity\PruebasDeGases;
use DBAL\Entity\Parametros;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use DBAL\Entity\NodosFirmantesRelevamiento;
use DBAL\Entity\RelevamientosxSecciones;
use DBAL\Entity\HerramientasxRelevamiento;
use DBAL\Entity\OperariosxRelevamiento;
use DBAL\Entity\Respuesta;
use DBAL\Entity\EmpresasContratistas;

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

    public function getAccion($idAccion = null){
        if ($idAccion){
            $Accion = $this->entityManager->getRepository(Accion::class)->findOneBy(['id' => $idAccion]);
        }else{
            $Accion = $this->entityManager->getRepository(Accion::class)->findAll();
        }

        return $Accion;
    }

    public function getOperacion($idOperacion = null){
        if ($idOperacion){
            $Operacion = $this->entityManager->getRepository(Operacion::class)->findOneBy(['id' => $idOperacion]);
        }else{
            $Operacion = $this->entityManager->getRepository(Operacion::class)->findAll();
        }

        return $Operacion;
    }

    public function getOperacionAccionPerfil($idOperacionAccionPerfil = null){
        if ($idOperacionAccionPerfil){
            $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)->findOneBy(['id' => $idOperacionAccionPerfil]);
        }else{
            $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)->findAll();
        }

        return $OperacionAccionPerfil;
    }

    public function getPerfiles($idPerfil = null){
        if ($idPerfil){
            $Perfiles = $this->entityManager->getRepository(Perfiles::class)->findOneBy(['id' => $idPerfil]);
        }else{
            $Perfiles = $this->entityManager->getRepository(Perfiles::class)->findAll();
        }

        return $Perfiles;
    }

    public function getParametros($idParametros = null){
        if ($idParametros){
            $Parametros = $this->entityManager->getRepository(Parametros::class)->findOneBy(['id' => $idParametros]);
        }else{
            $Parametros = $this->entityManager->getRepository(Parametros::class)->findAll();
        }

        return $Parametros;
    }

    public function getSecciones($idSeccion = null){
        if ($idSeccion){
            $Secciones = $this->entityManager->getRepository(Seccion::class)->findOneBy(['id' => $idSeccion]);
        }else{
            $Secciones = $this->entityManager->getRepository(Seccion::class)->findAll();
        }

        return $Secciones;
    }

    public function getPreguntas($idPregunta = null){
        if ($idPregunta){
            $Preguntas = $this->entityManager->getRepository(Pregunta::class)->findOneBy(['id' => $idPregunta]);
        }else{
            $Preguntas = $this->entityManager->getRepository(Pregunta::class)->findAll();
        }

        return $Preguntas;
    }

    public function getSeccionesPreguntasPorSeccion($Seccion){
        
        $SeccionPregunta = $this->entityManager->getRepository(SeccionPregunta::class)->findBy(['seccion' => $Seccion]);

        return $SeccionPregunta;
    }

    public function getSeccionesxRelevamiento($Relevamiento) {
        $SeccionesxRelevamiento = $this->entityManager->getRepository(RelevamientosxSecciones::class)->findBy(['relevamiento' => $Relevamiento]);

        return $SeccionesxRelevamiento;
    }

    public function getRespuestaxSeccionxRelevamiento($SeccionxRelevamiento) {
        $Respuesta = $this->entityManager->getRepository(Respuesta::class)->findBy(['relevamientoxSeccion' => $SeccionxRelevamiento]);

        return $Respuesta;
    }


    public function getAccionesPorPerfil($OperacionNombre, $Perfil){
        $Operacion = $this->entityManager->getRepository(Operacion::class)->findOneBy(['nombre' => $OperacionNombre]);
        $OperacionAccionPerfil = $this->entityManager->getRepository(OperacionAccionPerfil::class)
                                                        ->findBy(['Operacion' => $Operacion, 'Perfil' => $Perfil]);
        return $OperacionAccionPerfil;
    }

    public function getSeccionPregunta($Seccion, $Pregunta){
        $seccionPregunta = $this->entityManager->getRepository(SeccionPregunta::class)
                                        ->findOneBy(['pregunta' => $Pregunta, 'seccion' => $Seccion]);
        return $seccionPregunta;
    }

    public function getUsuarios($idUsuarios = null){
        if ($idUsuarios){
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findOneBy(['id' => $idUsuarios]);
        }else{
            $Usuarios = $this->entityManager->getRepository(Usuarios::class)->findBy([],['Nombre' => 'ASC']);
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

    public function getLugaresObras($idLugar = null){
        if ($idLugar){
            $Lugares = $this->entityManager->getRepository(LugaresDeObra::class)->findOneBy(['id' => $idLugar]);
        }else{
            $Lugares = $this->entityManager->getRepository(LugaresDeObra::class)->findAll();
        }
        return $Lugares;
    }

    public function getElementosProteccionPersonales($idElemento = null){
        if ($idElemento){
            $Elementos = $this->entityManager->getRepository(ElementosProteccionPersonal::class)->findOneBy(['id' => $idElemento]);
        }else{
            $Elementos = $this->entityManager->getRepository(ElementosProteccionPersonal::class)->findAll();
        }
        return $Elementos;
    }

    public function getHerramientasDeTrabajo($idHerramienta = null){
        if ($idHerramienta){
            $Herramientas = $this->entityManager->getRepository(HerramientasDeTrabajo::class)->findOneBy(['id' => $idHerramienta]);
        }else{
            $Herramientas = $this->entityManager->getRepository(HerramientasDeTrabajo::class)->findAll();
        }
        return $Herramientas;
    }

    public function getEntidadesRiesgosAmbientales($idRiesgosAmientales = null){
        if ($idRiesgosAmientales){
            $RiesgosAmbientales = $this->entityManager->getRepository(RiesgosAmbientales::class)->findOneBy(['id' => $idRiesgosAmientales]);
        }else{
            $RiesgosAmbientales = $this->entityManager->getRepository(RiesgosAmbientales::class)->findAll();
        }
        return $RiesgosAmbientales;
    }

    public function getRiesgosAdicionalesEntidades($idRiesgosAdicionales = null){
        if ($idRiesgosAdicionales){
            $Riesgos = $this->entityManager->getRepository(RiesgosAdicionales::class)->findOneBy(['id' => $idRiesgosAdicionales]);
        }else{
            $Riesgos = $this->entityManager->getRepository(RiesgosAdicionales::class)->findAll();
        }
        return $Riesgos;
    }

    public function getGases($idPruebaGases = null){
        if ($idPruebaGases){
            $Gases = $this->entityManager->getRepository(PruebasDeGases::class)->findOneBy(['id' => $idPruebaGases]);
        }else{
            $Gases = $this->entityManager->getRepository(PruebasDeGases::class)->findAll();
        }
        return $Gases;
    }

    public function getNodos($idNodos = null){
        if ($idNodos){
            $Nodos = $this->entityManager->getRepository(Nodos::class)->findOneBy(['id' => $idNodos]);
        }else{
            $Nodos = $this->entityManager->getRepository(Nodos::class)->findBy([],['Nombre' => 'ASC']);;
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

    public function getEsJefeDePorNodoUsuario($Nodo, $Usuario){
        $EsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findOneBy(['Nodo' => $Nodo, 'Usuario' => $Usuario]);

        return $EsJefeDe;
    }

    public function getEsJefeDePorNodo($Nodo){
        $arrEsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findBy(['Nodo' => $Nodo]);

        return $arrEsJefeDe;
    }

    public function getEsJefeDePorNodoOrden($Nodo, $Orden){
        $arrEsJefeDe = $this->entityManager->getRepository(esJefeDe::class)->findOneBy(['Nodo' => $Nodo, 'Orden' => $Orden]);

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

    public function getPlanificaciones($idPlanificaciones = null){
        if ($idPlanificaciones){
            $Planificaciones = $this->entityManager->getRepository(Planificaciones::class)->findOneBy(['id' => $idPlanificaciones]);
        }else{
            $Planificaciones = $this->entityManager->getRepository(Planificaciones::class)->findAll();
        }

        return $Planificaciones;
    }

    public function getTipoPlanificacion($idTipoPlanificacion = null){
        if ($idTipoPlanificacion){
            $TipoPlanificacion = $this->entityManager->getRepository(TipoPlanificacion::class)->findOneBy(['id' => $idTipoPlanificacion]);
        }else{
            $TipoPlanificacion = $this->entityManager->getRepository(TipoPlanificacion::class)->findAll();
        }

        return $TipoPlanificacion;
    }

    public function getTiposEvento($idTipoEvento = null){
        if ($idTipoEvento){
            $TiposEvento = $this->entityManager->getRepository(TiposEvento::class)->findOneBy(['id' => $idTipoEvento]);
        }else{
            $TiposEvento = $this->entityManager->getRepository(TiposEvento::class)->findAll();
        }

        return $TiposEvento;
    }

    public function getNotificacionesXPerfil($idNotificacionXPerfil = null){
        if ($idNotificacionXPerfil){
            $NotificacionesXPerfil = $this->entityManager->getRepository(NotificacionesXPerfil::class)->findOneBy(['id' => $idNotificacionXPerfil]);
        }else{
            $NotificacionesXPerfil = $this->entityManager->getRepository(NotificacionesXPerfil::class)->findAll();
        }

        return $NotificacionesXPerfil;
    }

    public function getEstadosRelevamiento($idEstadoRelevamiento = null){
        if ($idEstadoRelevamiento){
            $EstadosRelevamiento = $this->entityManager->getRepository(EstadosRelevamiento::class)->findOneBy(['id' => $idEstadoRelevamiento]);
        }else{
            $EstadosRelevamiento = $this->entityManager->getRepository(EstadosRelevamiento::class)->findAll();
        }

        return $EstadosRelevamiento;
    }

    public function getInducciones($idInducciones = null){
        if ($idInducciones){
            $Inducciones = $this->entityManager->getRepository(Inducciones::class)->findOneBy(['id' => $idInducciones]);
        }else{
            $Inducciones = $this->entityManager->getRepository(Inducciones::class)->findAll();
        }

        return $Inducciones;
    }

    public function getEmpresasContratistas($idEmpresaContratista = null){
        if ($idEmpresaContratista){
            $EmpresasContratistas = $this->entityManager->getRepository(EmpresasContratistas::class)->findOneBy(['id' => $idEmpresaContratista]);
        }else{
            $EmpresasContratistas = $this->entityManager->getRepository(EmpresasContratistas::class)->findAll();
        }

        return $EmpresasContratistas;
    }

    public function getTareaPorOrdenDeCompra($OrdenDeCompra){
        $Tareas = $this->entityManager->getRepository(Tareas::class)->findOneBy(['OrdenDeCompra' => $OrdenDeCompra]);

        return $Tareas;
    }

    public function getTareasParaPlanificar($Usuario){
        $Tareas = $this->entityManager->getRepository(Tareas::class)->findBy(['PlanificaTarea' => $Usuario]);

        return $Tareas;
    }

    public function getTareasParaEjecutar($Usuario){
        $Tareas = $this->entityManager->getRepository(Tareas::class)->findBy(['Ejecutor' => $Usuario]);

        return $Tareas;
    }

    public function getOperariosPorContratista($UsuarioActivo){
        $Operarios = $this->entityManager->getRepository(Operarios::class)->findBy(['Contratista' => $UsuarioActivo]);

        return $Operarios;
    }

    public function getNotificacionesXPerfilPorTipoEventoPerfil($TipoEvento, $Perfil){
        $NotificacionesXPerfil = $this->entityManager->getRepository(NotificacionesXPerfil::class)
                                                        ->findOneBy(['TipoEvento' => $TipoEvento, 'Perfil' => $Perfil]);

        return $NotificacionesXPerfil;
    }

    public function getNotificacionesXPerfilPorTipoEvento($TipoEvento){
        $NotificacionesXPerfil = $this->entityManager->getRepository(NotificacionesXPerfil::class)
                                                        ->findBy(['TipoEvento' => $TipoEvento]);

        return $NotificacionesXPerfil;
    }

    public function getInduccionXOperarioPorInduccion($Induccion){
        $InduccionXOperario = $this->entityManager->getRepository(InduccionXOperario::class)
                                                        ->findBy(['Induccion' => $Induccion]);

        return $InduccionXOperario;
    }

    public function getTiposEventoPorDescripcion($Descripcion){
        $TiposEvento = $this->entityManager->getRepository(TiposEvento::class)->findOneBy(['Descripcion' => $Descripcion]);

        return $TiposEvento;
    }

    public function getUsuariosXPerfilesPorPerfil($Perfil){
        $UsuariosxPerfiles = $this->entityManager->getRepository(UsuariosxPerfiles::class)->findBy(['Perfil' => $Perfil]);

        return $UsuariosxPerfiles;
    }

    public function getUsuarioPorRelevamiento($idRelevamiento) {
        $Planificacion = $this->entityManager->getRepository(Planificaciones::class)->findOneBy(['Relevamiento' => $idRelevamiento]);
        return $Planificacion->getTarea()->getSolicitante()->getNombreUsuario();
    }

    public function getTareasPorSolicitante($Usuario) {
        $Tareas = $this->entityManager->getRepository(Tareas::class)->findBy(['Solicitante' => $Usuario]);

        return $Tareas;
    }

    public function getPlanificacionPorRelevamiento($Relevamiento) {
        $Planificacion = $this->entityManager->getRepository(Planificaciones::class)->findOneBy(['Relevamiento' => $Relevamiento]);

        return $Planificacion;
    }

    /**
     * Funcion generica que busca una Entidad en particular, si se pasa el ID
     * como parametro, o de lo contrario recupera todas las entidades disponibles.
     * 
     * El parametro $claseEntidad tiene que ser: Entidad::class
     *
     * @param [string] $claseEntidad
     * @param [integer] $idEntidad
     * @return Entidad | array
     */
    public function getEntidades($claseEntidad, $idEntidad = null){
        //$claseEntidad = $claseEntidad;
        if ($idEntidad){
            $Entidades = $this->entityManager->getRepository($claseEntidad)->findOneBy(['id' => $idEntidad]);
        }else{
            $Entidades = $this->entityManager->getRepository($claseEntidad)->findAll();
        }

        return $Entidades;
    }

    /**
     * Funcion que transforma un arreglo de entidades, en un JSON.
     *
     * @param [array] $arrEntidad
     * @return String
     */
    public function arrEntidadesAJSON($arrEntidad){
        $output = [];
        
        foreach($arrEntidad as $Entidad){
            $output[] = $Entidad->getJSON();
        }

        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    /**
     * Funcion que devuelve el arreglo de todas las entidades
     * en formato JSON para ser enviado a la vista.
     * 
     * Recibe por parametro el nombre de la entidad, el cual debe ser
     * exactamente igual al de la clase PHP.
     *
     * @return string
     */
    public function getArrEntidadJSON($nombreEntidad){
        $nombreFuncion = 'get'.$nombreEntidad;
        $arrEntidad = $this->$nombreFuncion();

        return $this->arrEntidadesAJSON($arrEntidad);
    }

    public function getArrTareasPorSolicitanteJSON($Usuario){
        $arrTareas = $this->getTareasPorSolicitante($Usuario);

        $output = [];
        foreach($arrTareas as $Tarea){
            $output[] = $Tarea->getJSON();
        }

        $output = implode(',', $output);

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
        $elementos = $this->getElementosProteccionPersonales();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getDescripcion()];
        }
        return $resultado;
    }

    public function getHerramientas($Relevamiento){
        $resultado = [];
        $HerramientasxRelevamiento = $this->getHerramientasxRelevamiento($Relevamiento);
        foreach($HerramientasxRelevamiento as $HerramientaxRelevamiento){
            $Herramienta = $HerramientaxRelevamiento->getHerramienta();
            $resultado[] = ['id' => $Herramienta->getId(), 'descripcion' =>$Herramienta->getDescripcion()];
        }
        return $resultado;
    }

    public function getOperariosParaTrabajo($Relevamiento){
        $resultado = [];
        $OperariosxRelevamiento = $this->getOperariosxRelevamiento($Relevamiento);
        foreach($OperariosxRelevamiento as $OperarioxRelevamiento){
            $Operario = $OperarioxRelevamiento->getOperario();
            $nombre = $Operario->getApellido().', '.$Operario->getNombre();
            $resultado[] = ['id' => $Operario->getId(), 'descripcion' =>$nombre];
        }
        return $resultado;
    }

    public function getLugarObra() {
        $resultado = [];
        $elementos = $this->getLugaresObras();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getDescripcion()];
        }
        return $resultado;
    }

    public function getRiesgosAmbientales() {
        $resultado = [];
        $elementos = $this->getEntidadesRiesgosAmbientales();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getDescripcion()];
        }
        return $resultado;
    }

    public function getRiesgosAdicionales() {
        $resultado = [];
        $elementos = $this->getRiesgosAdicionalesEntidades();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getDescripcion()];
        }
        return $resultado;
    }

    public function getPruebaDeGases() {
        $resultado = [];
        $elementos = $this->getGases();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getDescripcion()];
        }
        return $resultado;
    }

    public function getFirmasPermiso() {
        $resultado = [];
        $elementos = $this->getNodos();
        foreach($elementos as $elemento){
            $resultado[] = ['id' => $elemento->getId(), 'descripcion' =>$elemento->getNombre()];
        }
        return $resultado;
    }

    public function getNodosFirmantesPorRelevamiento($Relevamiento){
        $NodosFirmantesRelevamiento = $this->entityManager->getRepository(NodosFirmantesRelevamiento::class)
                                                            ->findBy(['Relevamiento' => $Relevamiento]);
    
        return $NodosFirmantesRelevamiento;
    }

    public function getNodoFirmantePorRelevamientoYNodo($Relevamiento, $Nodo){
        $NodosFirmantesRelevamiento = $this->entityManager->getRepository(NodosFirmantesRelevamiento::class)
                                                            ->findOneBy(['Relevamiento' => $Relevamiento, 'Nodo' => $Nodo]);
    
        return $NodosFirmantesRelevamiento;
    }


    public function getRelevamientosxSecciones($Relevamiento, $Seccion){
        $RelevamientosxSecciones = $this->entityManager->getRepository(RelevamientosxSecciones::class)
                                                            ->findOneBy(['relevamiento' => $Relevamiento, 'seccion' => $Seccion]);
    
        return $RelevamientosxSecciones;
    }

    public function getRelevamientoxSeccion($id){
        $RelevamientosxSecciones = $this->entityManager->getRepository(RelevamientosxSecciones::class)
                                                            ->findOneBy(['id' => $id]);
    
        return $RelevamientosxSecciones;
    }

    public function getHerramientasxRelevamiento($Relevamiento) {
        $HerramientasxRelevamiento = $this->entityManager->getRepository(HerramientasxRelevamiento::class)
                                                            ->findBy(['relevamiento' => $Relevamiento]);
    
        return $HerramientasxRelevamiento;
    }

    public function getHerramientaxRelevamiento($Herramienta, $Relevamiento) {
        $HerramientaxRelevamiento = $this->entityManager->getRepository(HerramientasxRelevamiento::class)
                                                            ->findOneBy(['relevamiento' => $Relevamiento, 'herramienta' =>$Herramienta]);
    
        return $HerramientaxRelevamiento;
    }
    
    public function getOperariosxRelevamiento($Relevamiento) {
        $OperariosxRelevamiento = $this->entityManager->getRepository(OperariosxRelevamiento::class)
                                                            ->findBy(['relevamiento' => $Relevamiento]);
    
        return $OperariosxRelevamiento;
    }

    public function getOperarioxRelevamiento($Operario, $Relevamiento) {
        $OperarioxRelevamiento = $this->entityManager->getRepository(OperariosxRelevamiento::class)
                                                            ->findOneBy(['relevamiento' => $Relevamiento, 'operario' =>$Operario]);
    
        return $OperarioxRelevamiento;
    }

    public function getSeccionesObligatorias() { //ver
        $secciones = $this->entityManager->getRepository(Seccion::class)
                                                            ->findBy(['esObligatoria' => 1]);
    
        return $secciones;
    }
    
}