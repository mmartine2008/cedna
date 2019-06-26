<?php

namespace Formulario\Service;

use DBAL\Entity\Formulario;
use DBAL\Entity\Respuesta;
use DBAL\Entity\Opcion;
use DBAL\Entity\PreguntaOpcion;
use DBAL\Entity\Pregunta;
use DBAL\Entity\Seccion;
use DBAL\Entity\SeccionPregunta;
use DBAL\Entity\Relevamientos;
use DBAL\Entity\EstadosRelevamiento;
use DBAL\Entity\NodosFirmantesRelevamiento;
use DBAL\Entity\RelevamientosxSecciones;
use function GuzzleHttp\json_encode;
use DBAL\Entity\HerramientasxRelevamiento;
use DBAL\Entity\OperariosxRelevamiento;

class FormularioManager extends BaseFormularioManager {
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager, $datosEmpresa, $mailManager, $translator, $datosArchivos) 
    {
        parent::__construct($entityManager, $catalogoManager, $datosEmpresa, $mailManager, $translator, $datosArchivos);
    }

    public function getDatosEmpresa() {
        $output = [];
        
        foreach ($this->datosEmpresa as $index => $valor)
        {
            $output[$index] = $valor;
        }        
        
        return $output;
    }

    public function getPathFiles() {
        $output = [];
        
        foreach ($this->datosArchivos as $index => $valor)
        {
            $output[$index] = $valor;
        }        
        
        return $output;
    }

    public function getOpcion($id) {
        $Opcion = $this->entityManager->getRepository(Opcion::class)
                                            ->findOneBy(['id' => $id]); 
        return $Opcion;
    }

    public function getPreguntaOpcion($idPregunta) {
        $Entidad = $this->entityManager->getRepository(PreguntaOpcion::class)
                                            ->findBy(['pregunta' => $idPregunta]); 
        return $Entidad;
    }

    public function getPreguntasxSeccion($seccion) {
        $preguntas = $this->entityManager->getRepository(SeccionPregunta::class)
                                            ->findBy(['seccion' => $seccion]); 
        return $preguntas;
    }

    public function getSeccionesxRelevamientoxSecciones($relevamiento){
        $RelevamientosxSecciones = $relevamiento->getRelevamientosxSecciones($relevamiento);
        $output = [];
        foreach($RelevamientosxSecciones as $relevamientoxSeccion) {
            $output[] = $relevamientoxSeccion->getSeccion();
        }
        return $output;
    }

    public function getRespuesta($id = null) {
        if($id) {
            $Entidad = $this->entityManager->getRepository(Respuesta::class)
                                            ->findOneBy(['id' => $id]); 
        } else {
            $Entidad = $this->entityManager->getRepository(Respuesta::class)
                        ->findAll(); 
        }
        
        return $Entidad;
    }

    /**
     * Esta funcion recupera el listado de tareas para ejecutar del usuario conectado.
     * Lo retorna transformado en JSON.
     *
     * @param [type] $nombreUsuario
     * @return void
     */
    public function getArrTareasParaEjecutar($nombreUsuario){
        $Usuario = $this->catalogoManager->getUsuarioPorNombreUsuario($nombreUsuario);
        
        $arrTareas = $this->catalogoManager->getTareasParaEjecutar($Usuario);
        $JsonArrTareas = $this->catalogoManager->arrEntidadesAJSON($arrTareas);
        $JsonArrTareasValidas = $this->getTareasListasParaPlanificar($JsonArrTareas);
        return $JsonArrTareasValidas;
    }

    /**
     * Esta funcion retorna un arreglo de secciones dado un Json con id de secciones
     */
    public function getArraySecciones($JsonSecciones) {
        $output = Array();
        if($JsonSecciones) {
            foreach($JsonSecciones as $JsonSeccion) {
                $output[] = $this->catalogoManager->getSecciones($JsonSeccion->id);
            }
        }
        return $output;
    }

    public function puedeModificarRelevamiento($Relevamiento) {
        $seccionesxRelevamiento = $this->catalogoManager->getSeccionesxRelevamiento($Relevamiento);
        foreach($seccionesxRelevamiento as $seccionxRelev) {
            $Respuesta = $this->catalogoManager->getRespuestaxSeccionxRelevamiento($seccionxRelev);
            if($Respuesta) {
                return 0;
            }
        }
        return 1;
    }

    /**
     * Funcion que asignar un formulario a una planificacion.
     *
     * @param [JSON] $JsonData
     * @param [Planificaciones] $Planificacion
     * @return void
     */
    public function asignarSeccionesAPlanificacion($JsonData, $Planificacion, $Tarea){
        
        $SeccionesGlobales = $this->getArraySecciones($JsonData->seccionesGlobales);

        $SeccionesSeleccionadas = $this->getArraySecciones($JsonData->seccionesSeleccionadas);
        $SeccionesNoSeleccionadas = $this->getArraySecciones($JsonData->seccionesNoSeleccionadas);

        $Relevamiento = $Planificacion->getRelevamiento();

        if ($Relevamiento){

            if(!$SeccionesGlobales) {
                /** 
                 * aca agarro las secciones globales al relevamiento y las doy de alta 
                */
                $SeccionesGlobales = $this->getSeccionesGlobalesAlRelevamento($Tarea);
            }
            $this->desenlazarRelevamientosxSecciones($Relevamiento, $SeccionesNoSeleccionadas);
           
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            $Relevamiento = $this-> altaRelevamiento($EstadoParaEditar);

            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
        }
        $SeccionesObligatorias = $this->catalogoManager->getSeccionesObligatorias(); 
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesObligatorias, false);        
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesGlobales, true);
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesSeleccionadas, false);

        $this->entityManager->flush();

        if(($this->puedePlanificarTarea($Relevamiento)) &&
         ($this->puedeModificarRelevamiento($Relevamiento) == 1)) {
            $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
        }
    }

    private function crearNodoFirmante($Responsable, $Planificacion) {
        $Tarea = $Planificacion->getTarea();

        $Entidad = new NodosFirmantesRelevamiento();
        $Entidad->setNodo($Tarea->getNodo()); 
        $Entidad->setUsuarioFirmante($Responsable);
        $Entidad->setRelevamiento($Planificacion->getRelevamiento());
        
        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    /**
     * Funcion que cambia el estado del relevamiento, y lo coloca disponible
     * para ser firmado por los responsables.
     *
     * @param [integer] $idPlanificacion
     * @return void
     */
    public function colocarRelevamientoParaFimar($idPlanificacion){
        $EstadoCompleto = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_COMPLETO);
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);

        $Tarea = $Planificacion->getTarea();
        $Responsable = $Tarea->getResponsable();

        $Relevamiento = $Planificacion->getRelevamiento();
        $Relevamiento->setEstadoRelevamiento($EstadoCompleto);

        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();

        $this->crearNodoFirmante($Responsable,  $Planificacion); 
    }

    /**
     * Funcion que procesa la firma de un permiso de trabajo por parte del usuario.
     * 
     * Si todos los usuarios firmaron, entonces cambia el estado del relevamiento.
     *
     * @param [integer] $idPlanificacion
     * @param [Usuarios] $UsuarioActivo
     * @return void
     */
    public function firmarFormulario($idPlanificacion, $UsuarioActivo){
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();

        $NodosFirmantes = $Relevamiento->getNodosFirmantesRelevamiento();

        foreach($NodosFirmantes as $NodoFirmante){
            if ($NodoFirmante->getUsuarioFirmante() == $UsuarioActivo){
                $NodoFirmante->setFechaFirma(new \DateTime("now"));

                $this->entityManager->persist($NodoFirmante);
                $this->entityManager->flush();
                break;
            }
        }

        $todosFirmaron = $this->todosFirmaronRelevamiento($NodosFirmantes);
        
        if ($todosFirmaron){
            $this->finalizarRelevamiento($Relevamiento);
            $this->mailManager->notificarPermisoFirmadoCompletamente($Planificacion);
        }
    }

    /**
     * Funcion que se encarga de procesar la delegacion de la 
     * firma del usuario, hacia otro usuario que tenga un orden siguiente
     * en la jerarquia del nodo.
     *
     * @param [integer] $idPlanificacion
     * @param [Usuarios] $UsuarioActivo
     * @return String
     */
    public function delegarFirmaFormulario($idPlanificacion, $UsuarioActivo){
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();

        $NodosFirmantes = $Relevamiento->getNodosFirmantesRelevamiento();
        $UsuarioDelegado = '';
        foreach($NodosFirmantes as $NodoFirmante){
            if ($NodoFirmante->getUsuarioFirmante() == $UsuarioActivo){
                
                $UsuarioDelegado = $this->cambiarUsuarioFirmante($NodoFirmante, $UsuarioActivo);
                break;
            }
        }

        $this->mailManager->notificarFirmaDePermisoDelegada($Planificacion, $UsuarioActivo, $UsuarioDelegado);

        $mensaje = $this->translator->translate('__mensaje_delegacion_exitosa__').": ".$UsuarioDelegado->getNombre().', '.$UsuarioDelegado->getApellido();
        
        return $mensaje;
    }

    /**
     * Funcion que comprueba si el usuario activo puede delegar
     * la firma de un permiso de trabajo.
     * 
     * Para ello, debe existir otra persona responsable en el nodo, 
     * que se dea un orden inferior a él.
     *
     * @param [integer] $idNodo
     * @param [Usuarios] $UsuarioActivo
     * @return boolean
     */
    public function comprobarUsuarioPuedeDelegar($idNodo, $UsuarioActivo){
        $Nodo = $this->catalogoManager->getNodos($idNodo);

        $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodo, $UsuarioActivo);
        $OrdenJefeInferior = $esJefeDe->getOrden() + 1;
        
        $esJefeDeInferior = $this->catalogoManager->getEsJefeDePorNodoOrden($Nodo, $OrdenJefeInferior);

        if ($esJefeDeInferior){
            return true;
        }

        return false;
    }

    /**
     * Esta funcion retorna todas las preguntas que tiene un relevamiento
     */
    public function getPreguntasxRelevamiento($relevamiento) {
        $secciones = $this->getSeccionesxRelevamientoxSecciones($relevamiento);
        $arregloPreg = [];
        foreach($secciones as $seccion){
            $preguntasxSeccion = $this->getPreguntasxSeccion($seccion);
            foreach($preguntasxSeccion as $pregunta) {
                $arregloPreg[] = $pregunta->getPregunta();
            }
        }
        return $arregloPreg;
    }

    /**
     * Esta funcion retorna las opciones que tiene una pregunta, dada una funcion
     */
    public function getOpcionesFuncion($pregunta,  $seccionxRelevamiento) {
        $seccion =  $seccionxRelevamiento->seccion;
        $strinfFuncion = $pregunta->getFuncion();
        if($seccion->esObligatoria == 1) { //necesita relevamiento
            $relevamiento = $this->catalogoManager->getRelevamientos($seccionxRelevamiento->idRelevamiento);
            $opciones = $this->catalogoManager->{$strinfFuncion}($relevamiento);
        } else {
            $opciones = $this->catalogoManager->{$strinfFuncion}();
        }
        return $opciones;
    }

    /**
     * Esta funcion modifica el json insertandole las opciones a una pregunta select simple
     */
    public function getJSONModificadoSelectSimple($pregunta, $relev) {
        $seccionesxRelevamiento = $relev->secciones;
        foreach($seccionesxRelevamiento as $seccionxRelevamiento) {
            $seccion = $seccionxRelevamiento->seccion;
            $seccionPreguntas = $seccion->preguntas;
            foreach($seccionPreguntas as $seccionPregunta) {
                $preguntaJSON = $seccionPregunta->pregunta;
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta, $seccionxRelevamiento);
                    $preguntaJSON->opciones = $opciones;
                }
            }
        }
        return $relev;
    }

    
    public function getJSONActualizado($Relevamiento){
        $preguntas = $this->getPreguntasxRelevamiento($Relevamiento);
        $JSON = $Relevamiento->getJSON();
        $formJSON = json_decode($JSON);
        foreach($preguntas as $pregunta) {
            $formJSON = $this->getJSONActualizadoPorFuncion($pregunta, $formJSON);
        }
        //si requiere el JSON una vez editado el Relevamiento
        if($Relevamiento->getEstadoRelevamiento()->esEditado()){
            $output = $this->getJSONActualizadoPorRespuestasRelevamiento($formJSON, $Relevamiento->getId());
            return json_encode($output);
        }

        return json_encode($formJSON);
    }

    public function getRespuestasSegunRelevamiento($Relevamiento){
        $Respuestas = $this->getRespuesta();
        $output = [];
        foreach($Respuestas as $Respuesta) {
            if ($Respuesta->getRelevamientoxSeccion()->getRelevamiento()->getId() == $Relevamiento->getId()) {
                $output[] = $Respuesta;
            }
        }
        return $this->getRespuestasAgrupadasPorPregunta($output);
    }

    public function getArrTareasJSONFormulariosAFirmar($UsuarioActivo){
        $arrTareas = $this->catalogoManager->getTareas();
        $output = [];
        foreach ($arrTareas as $Tarea){
            $planificador = $Tarea->getPlanificaTarea();
            if ($planificador->getId() == $UsuarioActivo->getId()){
                $output[] = $Tarea->getJSON();
            }
        }
        return "[". implode(', ', $output) . "]";
    }

    public function getRespuestasPorPreguntas($Respuestas) {
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta()->getDescripcion(); 
            $tipoPregunta = $Respuesta->getPregunta()->getTipoPregunta();
            $esArchivo = $tipoPregunta->esImagen();

            if(!$tipoPregunta->esPeguntaMultiple()) {
                $respuestaOutput = $this->getRespuestaModificada($Respuesta);
            }
            $nombreArchivo = "";
            if($esArchivo) {
                $nombreArchivo = $Respuesta->getNombreArchivo();
            }
        }

        if($tipoPregunta->esPeguntaMultiple()) {
            $respuestaOutput = $this->getArrayRespuestasModificadas($Respuestas);
        }
        
        if($respuestaOutput) {
            $output[]= ['descripcionPregunta' => $pregunta,
                    'tipoPregunta' => $tipoPregunta->getDescripcion(),
                    'respuesta' => $respuestaOutput,
                    'archivo' => $nombreArchivo];
        }
        return $output;
    } 

    public function getRespuestas($Relevamiento){
        $output = [];
       
        $output = ['idRelevamiento' =>$Relevamiento->getId(), 
                    'secciones' => $this->getSeccionesPorFormulario($Relevamiento)
                    ];
     
        return $output;
    }

    public function tieneRespuesta($respuesta) {
        if ((!$respuesta) || ($respuesta == "-1")){
            return false; 
        } 
        return true;
    }

    public function altaRespuesta($pregunta, $relevamientoxSeccion, $respuesta, $destino, $opcion) {
        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        $Entidad->setRelevamientoxSeccion($relevamientoxSeccion);
        $Entidad->setDestino($destino);
        if($opcion){
            $Entidad->setOpcion($opcion);
        } else {
            $Entidad->setDescripcion($respuesta);
        }
        $this->entityManager->persist($Entidad);
        $this->entityManager->flush();
    }

    public function actualizarRespuesta($Respuesta, $respuesta, $destino, $opcion) {
        $Respuesta->setDestino($destino);
        if($opcion){
            $Respuesta->setOpcion($opcion);
        } else {
            $Respuesta->setDescripcion($respuesta);
        }
        $this->entityManager->persist($Respuesta);
        $this->entityManager->flush();
    }

    public function altaEdicionRespuesta($pregunta, $relevamientoxSeccion, $respuesta, $destino, $opcion) {
        $Respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccionDestino($relevamientoxSeccion, $pregunta, $destino);
        if(($Respuesta)&& (!$destino)) { 
            if($pregunta->getTipoPregunta()->esImagen()) {
                if($Respuesta->getDescripcion() != $respuesta) {
                    $this->actualizarRespuesta($Respuesta, $respuesta, $destino, $opcion);
                }
            } else {
                $this->actualizarRespuesta($Respuesta, $respuesta, $destino, $opcion);
            }
        } else {
            $this->altaRespuesta($pregunta, $relevamientoxSeccion, $respuesta, $destino, $opcion);
        }

        if (($relevamientoxSeccion->getSeccion()->esSeccionFirmas()) && (strpos($destino, 'destino_1_') !== false)){
            $this->AltaNodoFirmante($relevamientoxSeccion->getRelevamiento(), $opcion);
        }
    }

    public function altaRespuestasDestino($pregunta, $relevamientoxSeccion, $respuesta, $listaDestinos){
        foreach($listaDestinos as $item) {
            $destino = $item[0];
            $opcion = $item[1]->id;
            $this->altaEdicionRespuesta($pregunta, $relevamientoxSeccion, $respuesta, $destino, $opcion);
        }
    }

    public function getOpcionDestino($opciones, $destino){
        $output = [];
        foreach($opciones as $opcion) {
            $opcionDestino = Array();
            $opcionDestino[] = $destino;
            $opcionDestino[] = $opcion;
            $output[] = $opcionDestino;
        }
        return $output;
    }

    public function getListaOpcionDestinoPregunta($pregunta, $respuestas) {
        $output = [];
        if($pregunta->getTipoPregunta()->esPeguntaMultiple()) {
            foreach ($respuestas as $resp) {
                $destino = $resp->destino; //nombre destino
                $opciones = $resp->opcion;
                if($opciones){
                    $opcionesDestinos = $this->getOpcionDestino($opciones, $destino);
                    $output = array_merge($opcionesDestinos, $output);
                }
            }
        }
        return $output;
    }

    public function altaRespuestaDePregunta($pregunta, $relevamientoxSeccion){
        $respuesta = $pregunta->respuesta;
        if ($this->tieneRespuesta($respuesta)){
            $idPregunta = $pregunta->idPregunta;
            $preguntaEntidad = $this->catalogoManager->getPreguntas($idPregunta);
            $this->altaRespuestaSegunTipoRespuesta($preguntaEntidad, $relevamientoxSeccion, $respuesta);
        } else {
            $idPregunta = $pregunta->idPregunta;
            $preguntaEntidad = $this->catalogoManager->getPreguntas($idPregunta);
            $this->eliminarRespuestasSinResponder($preguntaEntidad, $relevamientoxSeccion);
        }
    }

    public function altaRespuestaPreguntasGeneradas($preguntasGeneradas, $relevamientoxSeccion){
        foreach($preguntasGeneradas as $preguntaGenerada) {
            if($preguntaGenerada->estado == "block"){
                $pregunta = $preguntaGenerada->preguntaGenerada;
                $this->altaRespuestaDePregunta($pregunta, $relevamientoxSeccion);
            }
        }
    }

    public function altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento){
        $idSeccion = $seccion->id;
        $seccionEnt = $this->catalogoManager->getSecciones($idSeccion);
        $relevamientoxSeccion = $this->catalogoManager->getRelevamientosxSecciones($Relevamiento, $seccionEnt);
        $seccionPreguntas = $seccion->preguntas;
        foreach ($seccionPreguntas as $seccionPregunta) {
            $pregunta = $seccionPregunta->pregunta;
            $this->altaRespuestaDePregunta($pregunta, $relevamientoxSeccion);
            if($pregunta->preguntasGeneradas) {
                $this->altaRespuestaPreguntasGeneradas($pregunta->preguntasGeneradas, $relevamientoxSeccion);
            }
        }
    }

    public function altaRespuestasYArchivosFormulario($Planificacion, $data, $listaArchivos, $archivo) {
        $Relevamiento = $Planificacion->getRelevamiento();
        $this->altaRespuestasFormulario($data, $Relevamiento);
        $this->guardarArchivos($listaArchivos, $archivo, $Relevamiento->getId());
    }

    public function getSeccionesPorRelevamiento($Relevamiento, $Tarea) {
        $output = [];
        $seccionesGlobales = [];
        $SeccionesRelacionada = [];
        $seccionesGlobales = $this->getSeccionesGlobalesAlRelevamento($Tarea);
        if($Relevamiento) {
            $RelevamientosxSecciones = $Relevamiento->getRelevamientosxSecciones();
            $SeccionesRelacionada =  $this->getSeccionesRelacionadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales);   
        }
        $SeccionesNoRelacinadas = $this->getSeccionesNoRelacinadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($seccionesGlobales);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($SeccionesNoRelacinadas);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($SeccionesRelacionada);
        
        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    public function getArrayHerramientas($JsonHerramientas) {
        $output = Array();
        if($JsonHerramientas) {
            foreach($JsonHerramientas as $JsonHerramienta) {
                $output[] = $this->catalogoManager->getHerramientasDeTrabajo($JsonHerramienta->id);
            }
        }
        return $output;
    }

    public function asignarHerramientasAPlanificacion($JsonData, $Planificacion) {
        $HerramientasSeleccionadas = $this->getArrayHerramientas($JsonData->herramientasSeleccionadas);
        $HerramientasNoSeleccionadas = $this->getArrayHerramientas($JsonData->herramientasNoSeleccionadas);

        $Relevamiento = $Planificacion->getRelevamiento();

        if ($Relevamiento){
            $this->desenlazarHerramientasDeRelevamiento($Relevamiento, $HerramientasNoSeleccionadas);
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            $Relevamiento = $this-> altaRelevamiento($EstadoParaEditar);

            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
            
        }
        $this->altaHerramientasxRelevamiento($Relevamiento, $HerramientasSeleccionadas);
        $this->entityManager->flush();

        if($this->puedePlanificarTarea($Relevamiento)) {
            $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
        }
    }

    public function getHerramientasPorRelevamiento($Relevamiento) {
        $output = [];
        $HerramientaRelacionada = [];
        if($Relevamiento) {
            $HerramientasxRelevamiento = $this->catalogoManager->getHerramientasxRelevamiento($Relevamiento) ;
            $HerramientaRelacionada =  $this->getHerramientasRelacionadasConRelevamiento($HerramientasxRelevamiento);   
        }
        $HerramientaNoRelacionada = $this->getHerramientasNoRelacinadasConRelevamiento($HerramientasxRelevamiento);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($HerramientaNoRelacionada);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($HerramientaRelacionada);
        
        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    public function getArrayOperarios($JsonOperares) {
        $output = Array();
        if($JsonOperares) {
            foreach($JsonOperares as $JsonOperario) {
                $output[] = $this->catalogoManager->getOperarios($JsonOperario->id);
            }
        }
        return $output;
    }

    public function asignarOperariosAPlanificacion($JsonData, $Planificacion) {
        $OperariosSeleccionadas = $this->getArrayOperarios($JsonData->operariosSeleccionadas);
        $OperariosNoSeleccionadas = $this->getArrayOperarios($JsonData->operariosNoSeleccionadas);

        $Relevamiento = $Planificacion->getRelevamiento();

        if ($Relevamiento){
            $this->desenlazarOperariosDeRelevamiento($Relevamiento, $OperariosNoSeleccionadas);
            
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            $Relevamiento = $this-> altaRelevamiento($EstadoParaEditar);

            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
        }

        $this->altaOperariosxRelevamiento($Relevamiento, $OperariosSeleccionadas);
        $this->entityManager->flush();
        
        if($this->puedePlanificarTarea($Relevamiento)) {
            $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
        }
    }

    public function getOperariosPorRelevamiento($Relevamiento) {
        $output = [];
        $OperarioRelacionado = [];
        if($Relevamiento) {
            $OperariosxRelevamiento = $this->catalogoManager->getOperariosxRelevamiento($Relevamiento) ;
            $OperarioRelacionado =  $this->getOperariosRelacionadosConRelevamiento($OperariosxRelevamiento);   
        }
        $OperarioNoRelacionado = $this->getOperariosNoRelacinadosConRelevamiento($OperariosxRelevamiento);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($OperarioNoRelacionado);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($OperarioRelacionado);
        
        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

}