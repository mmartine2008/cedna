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

class FormularioManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    private $catalogoManager;
    private $datosEmpresa;
    private $mailManager;
    private $translator;
    private $datosArchivos;
    
    /**
     * Constructor del Servicio
     */
    public function __construct($entityManager, $catalogoManager, $datosEmpresa, $mailManager, $translator, $datosArchivos) 
    {
        $this->entityManager = $entityManager;
        $this->catalogoManager = $catalogoManager;
        $this->datosEmpresa = $datosEmpresa;
        $this->mailManager = $mailManager;
        $this->translator = $translator;
        $this->datosArchivos = $datosArchivos;
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

    private function getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $idPregunta) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findBy(['pregunta' => $idPregunta, 'relevamientoxSeccion' => $relevamientoxSeccion]); 
        
        return $respuesta;
    }

    private function getRespuestaPreguntaPorRelevamientoSeccionDestino($relevamientoxSeccion, $pregunta, $destino) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findOneBy(['pregunta' => $pregunta, 'relevamientoxSeccion' => $relevamientoxSeccion, 'destino' => $destino]); 
        
        return $respuesta;
    }

    private function todasLasPlanificacionesListas($Planificaciones) {
        foreach($Planificaciones as $Planificacion) {
            $Relevamiento = $Planificacion->getRelevamiento();
            if($Relevamiento) {
                //si cumpple bien, sino retorna falso
                    //tienen que tener secciones,. herramientas y operadores
            } else {
                return false;
            }
        }
        return true;
    }

    private function getTareasListasParaPlanificar($arrTareas) {
        $output = [] ;
        foreach($arrTareas as $tarea) {
            $Planificaciones = $tarea->getPlanificaciones();
            if($this->todasLasPlanificacionesListas($Planificaciones)) {
                $output[] = $tarea;
            }
        }
        return $output;
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
        $arrTareasValidas = $this->getTareasListasParaPlanificar($arrTareas);
        return $this->catalogoManager->arrEntidadesAJSON($arrTareasValidas);
    }

    private function altaRelevamientosxSecciones($Relevamiento, $Secciones, $globales) {
        foreach ($Secciones as $Seccion){
            $RelevamientoxSeccion = $this->catalogoManager->getRelevamientosxSecciones($Relevamiento, $Seccion);
            if(!$RelevamientoxSeccion) {
                $RelevamientoxSeccion = new RelevamientosxSecciones();
                
                $RelevamientoxSeccion->setRelevamiento($Relevamiento);
                $RelevamientoxSeccion->setSeccion($Seccion);
                $RelevamientoxSeccion->setSeccionGlobal($globales);
                
                $this->entityManager->persist($RelevamientoxSeccion);
            }
        }
    }

    private function desenlazarRelevamientosxSecciones($Relevamiento, $Secciones) {
        foreach ($Secciones as $Seccion){
            $RelevamientoxSeccion = $this->catalogoManager->getRelevamientosxSecciones($Relevamiento, $Seccion);
            if($RelevamientoxSeccion) {               
                $this->eliminarEntidad($RelevamientoxSeccion);
            }
        }
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

    private function altaRelevamiento($EstadoParaEditar) {
        $Relevamiento = new Relevamientos();
        $Relevamiento->setEstadoRelevamiento($EstadoParaEditar);
        
        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();

        return $Relevamiento;
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
                *(incluye secciones obligatorias)
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
        $SeccionesObligatorias = $this->catalogoManager->getSeccionesObligatorias(); //ver
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesObligatorias, false);
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesGlobales, true);
        $this->altaRelevamientosxSecciones($Relevamiento, $SeccionesSeleccionadas, false);
        
        

        $this->entityManager->flush();
        // $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
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

        $Relevamiento = $Planificacion->getRelevamiento();
        $Relevamiento->setEstadoRelevamiento($EstadoCompleto);

        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();
    }

    /**
     * Funcion que cambia de estado el relevamiento, y lo coloca como Finalizado
     *
     * @param [Relevamientos] $Relevamiento
     * @return void
     */
    private function finalizarRelevamiento($Relevamiento){
        $EstadoFinalizado = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_FINALIZADO);
        $Relevamiento->setEstadoRelevamiento($EstadoFinalizado);

        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();
    }

    /**
     * Funcion que comprueba si todos los usuarios firmaron el permiso de trabajo.
     *
     * @param [array] $NodosFirmantes
     * @return boolean
     */
    private function todosFirmaronRelevamiento($NodosFirmantes){
        foreach($NodosFirmantes as $NodoFirmante){
            $fechaFirma = $NodoFirmante->getFechaFirma();
            if (!isset($fechaFirma)){
                return false;
            }
        }

        return true;
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
            // $this->mailManager->notificarPermisoFirmadoCompletamente($Planificacion);
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

        // $this->mailManager->notificarFirmaDePermisoDelegada($Planificacion, $UsuarioActivo, $UsuarioDelegado);

        $mensaje = $this->translator->translate('__mensaje_delegacion_exitosa__').": ".$UsuarioDelegado->getNombre().', '.$UsuarioDelegado->getApellido();
        
        return $mensaje;
    }

    /**
     * Funcion que cambia en la base de datos, el usuario 
     * que tiene que firmar el permiso de trabajo.
     *
     * @param [Nodos] $NodoFirmante
     * @param [Usuarios] $UsuarioActivo
     * @return Usuarios
     */
    private function cambiarUsuarioFirmante($NodoFirmante, $UsuarioActivo){
        $Nodo = $NodoFirmante->getNodo();

        $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodo, $UsuarioActivo);
        $OrdenJefeInferior = $esJefeDe->getOrden() + 1;
        $esJefeDeInferior = $this->catalogoManager->getEsJefeDePorNodoOrden($Nodo, $OrdenJefeInferior);

        $NodoFirmante->setUsuarioFirmante($esJefeDeInferior->getUsuario());

        $this->entityManager->persist($NodoFirmante);
        $this->entityManager->flush();

        return $esJefeDeInferior->getUsuario();
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
                    $opciones = $this->getOpcionesFuncion($pregunta);
                    $preguntaJSON->opciones = $opciones;
                }
            }
        }
        return $relev;
    }

    /**
     *  Esta funcion modifica el json insertandole las opciones a una pregunta select multiple
     */
    public function getJSONModificadoSelectMultiple($pregunta, $relev) {
        $seccionesxRelevamiento = $relev->secciones;
        foreach($seccionesxRelevamiento as $seccionxRelevamiento) {
            $seccion = $seccionxRelevamiento->seccion;
            $seccionPreguntas = $seccion->preguntas;
            foreach($seccionPreguntas as $seccionPregunta) {
                $preguntaJSON = $seccionPregunta->pregunta;
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta,  $seccionxRelevamiento);
                    $respuestas = $preguntaJSON->respuesta;
                    $destino = 'destino_0_id_'.$pregunta->getId();
                    foreach($respuestas as $respuesta) {
                        if($respuesta->destino == $destino){
                            $opcionesJSON = $opciones;
                            $respuesta->opcion = $opcionesJSON;
                        }
                    }
                }
            }
        }
        return $relev;
    }

    private function getDescripcionOpcion($opciones, $idOpcion) {
        foreach($opciones->opcion as $opcion) {
            if($opcion['id'] == $idOpcion) {
                return $opcion['descripcion'];
            }
        }
    }

    /**
     * retorna una lista de destinos con sus respectivas opciones compuestas por un id y una descripcion
     */
    private function getListaValoresPorDestino($respuestas, $opciones){
        $destinoAcum = '';
        $ArrayAcum = [];
        $output = [];
        foreach($respuestas as $respuesta) {
            $destino = $respuesta->getDestino();
            if($destinoAcum != $destino) {
                if($ArrayAcum) {
                    $output[] = ['destino' => $destinoAcum, 'opciones' => $ArrayAcum];
                    $ArrayAcum = [];
                }
                $destinoAcum = $destino;
            }
            $descripcionOpcion = $this->getDescripcionOpcion($opciones, $respuesta->getOpcion());
            $ArrayAcum[] = ['id' => $respuesta->getOpcion(), 'descripcion' => $descripcionOpcion];
        }
        $output[] = ['destino' => $destino, 'opciones' => $ArrayAcum];

        return $output;
    }

    private function modificarOpcionesDeDestino($resp, $seccion, $destino){
        if($destino['destino'] == $resp->destino."_seccion_".$seccion->id) {
            $resp->opcion = $destino['opciones'];
        }
        return $resp;
    }

    /**
     * elimina las opciones encontradas en una respuesta
     */
    private function vaciarRespuestas($respuestasJSON) {
        foreach ($respuestasJSON as $respuesta) {
            $opciones = $respuesta->opcion;
            if($opciones) {
                $respuesta->opcion = [];
            }
        }
        return $respuestasJSON;
    }

    private function getRespuestaUsuario($respuesta) {
        foreach ($respuesta as $valor) {
            if($valor->getDescripcion()) {
                if($valor->getNombreArchivo()) {
                    return ['id' => $valor->getId(), 'valor' => $valor->getDescripcion()];
                } else {
                    return  $valor->getDescripcion();
                }
            } else {
                return  $valor->getOpcion();
            }
        }
    }

    /**
     * retorna un json de una pregunta con su respectiva respuesta
     */
    private function getPreguntaJSONConRespuesta($tipoPregunta, $respuesta, $preguntaJSON, $seccion){
        if($tipoPregunta->descripcion == 'multiple'){
            $listaDestinos = $this->getListaValoresPorDestino($respuesta, $preguntaJSON->respuesta[0]);
            $preguntaJSON->respuesta = $this->vaciarRespuestas($preguntaJSON->respuesta);
            foreach($listaDestinos as $destino) {
                foreach($preguntaJSON->respuesta as $resp) {
                    $resp = $this->modificarOpcionesDeDestino($resp, $seccion, $destino);
                }
            }
        } else {
            $preguntaJSON->respuesta = $this->getRespuestaUsuario($respuesta);
        }
        return $preguntaJSON;
    }

    
    private function getJSONActualizadoPorRespuestasRelevamiento($relev) {
        $seccionesxRelevamiento = $relev->secciones;
        foreach($seccionesxRelevamiento as $seccionxRelevamiento) {
            $seccion = $seccionxRelevamiento->seccion;
            $seccionPreguntas = $seccion->preguntas;
            foreach($seccionPreguntas as $seccionPregunta) {
                $preguntaJSON = $seccionPregunta->pregunta;
                $tipoPregunta = $preguntaJSON->tipoPregunta;
                $relevamientoxSeccion = $this->catalogoManager->getRelevamientosxSecciones($relev->id, $seccion->id);
                $respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $preguntaJSON->idPregunta);
                if($respuesta) {
                    $preguntaJSON = $this->getPreguntaJSONConRespuesta($tipoPregunta, $respuesta, $preguntaJSON, $seccion);
                    $preguntasGeneradoras = $preguntaJSON->preguntasGeneradas;
                    if($preguntasGeneradoras) {
                        foreach($preguntasGeneradoras as $preguntaGeneradora) {
                            $opcionGeneradora = $preguntaGeneradora->opcion;
                            if($preguntaJSON->respuesta == $opcionGeneradora->id) {
                                $respuestaPregGeneradora= $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $preguntaGeneradora->preguntaGenerada->idPregunta);
                                $preguntaGeneradora->preguntaGenerada = $this->getPreguntaJSONConRespuesta($preguntaGeneradora->preguntaGenerada->tipoPregunta, $respuestaPregGeneradora, $preguntaGeneradora->preguntaGenerada, $seccion);
                            }
                        }
                    }
                }
            }
        } 
        return $relev;
    }

    private function getJSONActualizadoPorFuncion($pregunta, $formJSON) {
        $output = $formJSON;
        if($pregunta->tieneFuncion()){
            $cantDestinos = $pregunta->getTipoPregunta()->getCantDestinos();
            if($cantDestinos > 0){
                $output = $this->getJSONModificadoSelectMultiple($pregunta, $formJSON);
            } else {
                $output = $this->getJSONModificadoSelectSimple($pregunta, $formJSON);
            }  
        }
        return $output;
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

    private function getRespuestasAgrupadasPorPregunta($Respuestas) {
        $idAcum = -1;
        $ArrayAcum = [];
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $idPregunta = $Respuesta->getPregunta()->getId();
            
            if($idAcum != $idPregunta) {
                $idAcum = $idPregunta;
                if($ArrayAcum) {
                    $output[] = $ArrayAcum;
                    $ArrayAcum = [];
                }
            }
            $ArrayAcum[] = $Respuesta;
        }
        $output[] = $ArrayAcum;

        return $output;
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
            $arrPlanificaciones = $Tarea->getPlanificaciones();

            foreach ($arrPlanificaciones as $Planificacion){
                $Relevamiento = $Planificacion->getRelevamiento();
                if ($Relevamiento){
                    $arrNodosFirmantes = $Relevamiento->getNodosFirmantesRelevamiento();
                    
                    foreach ($arrNodosFirmantes as $NodoFirmante){
                        if ($NodoFirmante->getUsuarioFirmante() == $UsuarioActivo){
                            $output[] = $Tarea->getJSON();
                        }
                    }
                }
            }
        }
        return "[". implode(', ', $output) . "]";
    }

    private function getValorFuncion($funcion, $opcion, $idRelevamientoxSeccion){
        $RelevamientoxSeccion = $this->catalogoManager->getRelevamientoxSeccion($idRelevamientoxSeccion);
        $Seccion = $RelevamientoxSeccion->getSeccion();
        if($Seccion->getEsObligatoria() == 1) {
            $opciones = $this->catalogoManager->{$funcion}($RelevamientoxSeccion->getRelevamiento());
        } else {
            $opciones = $this->catalogoManager->{$funcion}();
        }
        
        $objOpciones = json_decode(json_encode($opciones));
        foreach($objOpciones as $opcionFuncion) {
            if($opcionFuncion->id == $opcion){
                return $opcionFuncion->descripcion;
            }
        }
    }

    private function getRespuestaModificada($Respuesta) {
        $JSON = $Respuesta->getJSON();
        $respuestaDec = json_decode($JSON);

        $pregunta = $respuestaDec->pregunta;
        if($pregunta->cerrada == 1) {
            if($pregunta->funcion) {
                $valorOpcion = $this->getValorFuncion($pregunta->funcion, $respuestaDec->opcion, $respuestaDec->idRelevamientoxSeccion);
            } else {
                $valorOpcion = $this->getOpcion($respuestaDec->opcion)->getDescripcion();
            }
            $respuestaDec->respuesta = $valorOpcion;
        }
       
        return json_decode(json_encode($respuestaDec), true);
    }

    private function getArrayRespuestasModificadas($Respuestas) {
        $output = [];
        $destinoSeleccionado = 1;
        $ArrayAcum = [];
        foreach($Respuestas as $Respuesta){
            $destino = $Respuesta->getDestino();
            list($dest, $nroDestino, $id, $idPregunta, $seccion, $idSeccion) = explode("_", $destino);
            if($nroDestino == 1) {
                $ArrayAcum[] = $this->getRespuestaModificada($Respuesta);
            }
        }
        if($ArrayAcum) {
            $output[] = ['destino' => $destinoSeleccionado,
                                'respuestas' => $ArrayAcum];
        }
        return $output;
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

    private function respuestasSonTipoPDF($Respuestas) {
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta();
            $tipoPregunta = $pregunta->getTipoPregunta();
            if($tipoPregunta->esPDF()){
                return true;
            }
            return false;
        }
    }

    private function respuestasPertenecenASeccion($Respuestas, $idSeccion) {
        foreach($Respuestas as $Respuesta) {
            if($Respuesta->getRelevamientoxSeccion()->getSeccion()->getId() == $idSeccion){
                return true;
            }
            return false;
        }
    }

    private function getRespuestaPorSeccion($RespuestasRelevamiento, $idSeccion){
        $respuestas = [];
        foreach($RespuestasRelevamiento as $Respuestas){
            if(($this->respuestasPertenecenASeccion($Respuestas, $idSeccion)) 
                && (!$this->respuestasSonTipoPDF($Respuestas) )){
                    if($this->getRespuestasPorPreguntas($Respuestas)) {
                        $respuestas[] = $this->getRespuestasPorPreguntas($Respuestas);
                    }
            } 
        } 
        return $respuestas ;
    } 

    private function getSeccionesPorFormulario($Relevamiento){
        $RespuestasRelevamiento = $this->getRespuestasSegunRelevamiento($Relevamiento);
        $RelevamientoxSecciones = $Relevamiento->getRelevamientosxSecciones();
        foreach($RelevamientoxSecciones as $RelevamientoxSeccion) {
            $seccion = $RelevamientoxSeccion->getSeccion();
            $respuestas = $this->getRespuestaPorSeccion($RespuestasRelevamiento, $seccion->getId());
            if($respuestas) {
                $output[] = ['idSeccion' => $seccion->getId(), 'descripcionSeccion' =>$seccion->getDescripcion(), 
                    'respuestas' => $respuestas];
            }
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

    private function vaciarNodosFirmantes($Relevamiento){
        $arrNodosFirmantes = $this->catalogoManager->getNodosFirmantesPorRelevamiento($Relevamiento);

        foreach($arrNodosFirmantes as $NodoFirmanteRelevamiento){
            $this->elminarEntidad($NodoFirmanteRelevamiento);
        }
    }

    private function AltaNodoFirmante($Relevamiento, $id_nodo){
        $Nodo = $this->catalogoManager->getNodos($id_nodo);
        $NodoFirmante = $this->catalogoManager->getNodoFirmantePorRelevamientoYNodo($Relevamiento, $Nodo);
        if (!$NodoFirmante){
            $NodoFirmante = new NodosFirmantesRelevamiento();

            $NodoFirmante->setRelevamiento($Relevamiento);
            $NodoFirmante->setNodo($Nodo);

            $arrJefes = $Nodo->getJefes();
            $NodoFirmante->setUsuarioFirmante($arrJefes[0]);

            $this->entityManager->persist($NodoFirmante);
            $this->entityManager->flush();
        }
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

    private function modificarNombresArchivo($idRespuestaPregunta, $nombreArchivo, $nombreReal) {
        list($pregunta, $idPregunta, $seccion, $idSeccion, $relevamiento, $idRelevamiento) = explode("_", $idRespuestaPregunta);
        $Respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccion($idRelevamiento, $idSeccion, $idPregunta);

        foreach($Respuesta as $resp) {
            $resp->setNombreArchivo($nombreArchivo);
            $resp->setDescripcion($nombreReal);
            
            $this->entityManager->persist($resp);
            $this->entityManager->flush();
        }

    }

    private function guardarArchivos($listaArchivos, $archivo, $idRelevamiento) {
        for($i = 0; $i < count($listaArchivos); $i++) {
            if ($archivo) {
                $nombreUsuario = $this->catalogoManager->getUsuarioPorRelevamiento($idRelevamiento);
                $fecha_hoy = date("Y-m-d-H:i:s");
                $nombreReal = $archivo['name'][$i];
                if($nombreReal) {
                    $file_ext = pathinfo($nombreReal, PATHINFO_EXTENSION);
                    $nombreArchivo = $nombreUsuario."-".$fecha_hoy.".".$file_ext;
                    $path = $this->getPathFiles();
                    $ruta_destino_archivo = $path['path']."/".$nombreArchivo;
                    $archivo_ok = move_uploaded_file($archivo['tmp_name'][$i], $ruta_destino_archivo);
                    $this->modificarNombresArchivo($listaArchivos[$i], $nombreArchivo, $nombreReal);
                }
            }
        }
    }

    private function eliminarEntidad($Entidad) {
        $this->entityManager->beginTransaction();
        try {
            $entityManager = $this->entityManager;
            $entityManager->remove($Entidad);
            $entityManager->flush();

            $this->entityManager->commit();

            return true;
        } catch (\Exception $e) {

            $this->entityManager->rollBack();

            return false;
        }
    }

    private function eliminarRespuestasSelectores($preguntaEntidad, $relevamientoxSeccion) {
        $entidades = $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $preguntaEntidad);
        foreach($entidades as $entidad) {
            $this->eliminarEntidad($entidad);
        }
    }

    private function altaRespuestaSegunTipoRespuesta($preguntaEntidad, $relevamientoxSeccion, $respuesta){
        $listaOpcionDestino = $this->getListaOpcionDestinoPregunta($preguntaEntidad, $respuesta);
        if ($listaOpcionDestino){
            $this->eliminarRespuestasSelectores($preguntaEntidad, $relevamientoxSeccion);
            $this->altaRespuestasDestino($preguntaEntidad, $relevamientoxSeccion, $respuesta, $listaOpcionDestino);
        } else {
            $opcion = null;
            if ($preguntaEntidad->tieneOpciones()) {
                $opcion = $respuesta;
            }   
            $this->altaEdicionRespuesta($preguntaEntidad, $relevamientoxSeccion, $respuesta, null, $opcion);
        }
    }

    private function eliminarRespuestasSinResponder($Pregunta, $relevamientoxSeccion) {
        $Respuestas = $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $Pregunta);
        foreach($Respuestas as $Respuesta) {
            $this->elminarEntidad($Respuesta);
        } 
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

    private function altaRespuestasFormulario($datos, $Relevamiento) {
        $seccionesxRelevamiento = $datos->secciones;

        $this->vaciarNodosFirmantes($Relevamiento);
        foreach ($seccionesxRelevamiento as $seccionxRelevamiento) {
            $seccion = $seccionxRelevamiento->seccion;
            $this->altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento);
        }

        $EstadoEditado = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_EDITADO);
        $Relevamiento->setEstadoRelevamiento($EstadoEditado);

        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();
    }

    public function altaRespuestasYArchivosFormulario($Planificacion, $data, $listaArchivos, $archivo) {
        $Relevamiento = $Planificacion->getRelevamiento();
        $this->altaRespuestasFormulario($data, $Relevamiento);
        $this->guardarArchivos($listaArchivos, $archivo, $Relevamiento->getId());
    }

    private function seccionNoRelacionada($Seccion, $RelevamientosxSecciones){
        if($RelevamientosxSecciones){
            foreach($RelevamientosxSecciones as $RelevxSeccion) {
                $seccionActual = $RelevxSeccion->getSeccion();
                if($seccionActual->getId() == $Seccion->getId()) {
                    return false;
                }
            }
        }
        return true;
    }

    private function getSeccionesGlobalesAlRelevamento($Tarea){
        $output = [];
        foreach ($Tarea->getPlanificaciones() as $Planificacion) {
            
            $Relevamiento = $Planificacion->getRelevamiento();
            if($Relevamiento) {
                $RelevxSecciones = $Relevamiento->getRelevamientosxSecciones();
                if($RelevxSecciones) {
                    foreach($RelevxSecciones as $RelevxSeccion) {
                        if($RelevxSeccion->getSeccionGlobal()) {
                            $Seccion = $RelevxSeccion->getSeccion();
                            $output[] =  $Seccion;
                        }
                    }
                }
            }
        }
        return $output;
    }

    private function seccionPerteneceAGlobales($seccionesGlobales, $Seccion) {
        foreach($seccionesGlobales as $seccionGlobal) {
            if($seccionGlobal->getId() == $Seccion->getId()) {
                return true;
            }
        }
        return false;
    }

    private function getSeccionesNoRelacinadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales) {
        $Secciones = $this->catalogoManager->getSecciones();
        $output = [];
        foreach($Secciones as $Seccion) {
            if(($this->seccionNoRelacionada($Seccion, $RelevamientosxSecciones)) &&
                (!$this->seccionPerteneceAGlobales($seccionesGlobales, $Seccion))
                &&($Seccion->getEsObligatoria() == 0) ){
                $output[] = $Seccion;
            }
        }
        return $output;
    }

    private function getSeccionesRelacionadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales) {
        $output = [];
        if($RelevamientosxSecciones) {
            foreach($RelevamientosxSecciones as $RelevxSeccion) {
                $Seccion = $RelevxSeccion->getSeccion();
                if(!$this->seccionPerteneceAGlobales($seccionesGlobales, $Seccion)
                &&($Seccion->getEsObligatoria() == 0)) {
                    $output[] =  $Seccion;
                }
            }
        }
        return $output;
    }

    public function getSeccionesPorRelevamiento($Relevamiento, $Tarea) {
        $output = [];
        $seccionesGlobales = [];
        $SeccionesRelacionada = [];
        if($Relevamiento) {
            $RelevamientosxSecciones = $Relevamiento->getRelevamientosxSecciones();
            $SeccionesRelacionada =  $this->getSeccionesRelacionadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales);   
        }
        $seccionesGlobales = $this->getSeccionesGlobalesAlRelevamento($Tarea);
        $SeccionesNoRelacinadas = $this->getSeccionesNoRelacinadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($seccionesGlobales);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($SeccionesNoRelacinadas);
        $output[] = $this->catalogoManager->arrEntidadesAJSON($SeccionesRelacionada);
        
        $output = implode(", ", $output);

        return '[' . $output . ']';
    }

    private function desenlazarHerramientasDeRelevamiento($Relevamiento, $Herramientas) {
        foreach ($Herramientas as $Herramienta){
            $HerramientaxRelevamiento = $this->catalogoManager->getHerramientaxRelevamiento($Herramienta, $Relevamiento);
            
            if($HerramientaxRelevamiento) {    
                $this->eliminarEntidad($HerramientaxRelevamiento);  
            }
        }
    }

    private function altaHerramientasxRelevamiento($Relevamiento, $Herramientas) {
        foreach ($Herramientas as $Herramienta){
            $HerramientaxRelevamiento = $this->catalogoManager->getHerramientaxRelevamiento($Herramienta, $Relevamiento);
            if(!$HerramientaxRelevamiento) {
                $HerramientaxRelevamiento = new HerramientasxRelevamiento();
                
                $HerramientaxRelevamiento->setRelevamiento($Relevamiento);
                $HerramientaxRelevamiento->setHerramienta($Herramienta);
                
                $this->entityManager->persist($HerramientaxRelevamiento);
                $this->entityManager->flush();
            }
        }
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
            // $this->altaHerramientasxRelevamiento($Relevamiento, $HerramientasSeleccionadas);
            $this->desenlazarHerramientasDeRelevamiento($Relevamiento, $HerramientasNoSeleccionadas);
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            $Relevamiento = $this-> altaRelevamiento($EstadoParaEditar);

            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
            
            // $this->altaHerramientasxRelevamiento($Relevamiento, $HerramientasSeleccionadas);
        }
        $this->altaHerramientasxRelevamiento($Relevamiento, $HerramientasSeleccionadas);
        $this->entityManager->flush();
        // $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
    }

    private function getHerramientasRelacionadasConRelevamiento($HerramientasxRelevamiento) {
        $output = [];
        if($HerramientasxRelevamiento) {
            foreach($HerramientasxRelevamiento as $herramientaxRelevamiento) {
                $herramienta = $herramientaxRelevamiento->getHerramienta();
                $output[] =  $herramienta;     
            }
        }
        return $output;
    }

    private function herramientaNoRelacionada($Herramienta, $HerramientasxRelevamiento){
        if($HerramientasxRelevamiento){
            foreach($HerramientasxRelevamiento as $HerramientaxRelevamiento) {
                $herramientaActual = $HerramientaxRelevamiento->getHerramienta();
                if($herramientaActual->getId() == $Herramienta->getId()) {
                    return false;
                }
            }
        }
        return true;
    }

    private function getHerramientasNoRelacinadasConRelevamiento($HerramientasxRelevamiento) {
        $Herramientas = $this->catalogoManager->getHerramientasDeTrabajo();
        $output = [];
        foreach($Herramientas as $Herramienta) {
            if($this->herramientaNoRelacionada($Herramienta, $HerramientasxRelevamiento)) {
                $output[] = $Herramienta;
            }
        }
        return $output;
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

  
    private function desenlazarOperariosDeRelevamiento($Relevamiento, $Operarios) {
        foreach ($Operarios as $Operario){
            $OperarioxRelevamiento = $this->catalogoManager->getOperarioxRelevamiento($Operario, $Relevamiento);
            if($OperarioxRelevamiento) {               
                $this->eliminarEntidad($OperarioxRelevamiento);
            }
        }
    }

    private function altaOperariosxRelevamiento($Relevamiento, $Operarios) {
        foreach ($Operarios as $Operario){
            $OperarioxRelevamiento = $this->catalogoManager->getOperarioxRelevamiento($Operario, $Relevamiento);
            if(!$OperarioxRelevamiento) {
                $OperarioxRelevamiento = new OperariosxRelevamiento();
                
                $OperarioxRelevamiento->setRelevamiento($Relevamiento);
                $OperarioxRelevamiento->setOperario($Operario);
                
                $this->entityManager->persist($OperarioxRelevamiento);
            }
        }
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
            // $this->altaOperariosxRelevamiento($Relevamiento, $OperariosSeleccionadas);
            $this->desenlazarOperariosDeRelevamiento($Relevamiento, $OperariosNoSeleccionadas);
            
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            $Relevamiento = $this-> altaRelevamiento($EstadoParaEditar);

            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
            // $this->altaOperariosxRelevamiento($Relevamiento, $OperariosSeleccionadas);
        }

        $this->altaOperariosxRelevamiento($Relevamiento, $OperariosSeleccionadas);
        $this->entityManager->flush();
        // $this->mailManager->notificarPermisoDisponibleParaEditar($Planificacion);
    }

    private function getOperariosRelacionadosConRelevamiento($OperariosxRelevamiento) {
        $output = [];
        if($OperariosxRelevamiento) {
            foreach($OperariosxRelevamiento as $OperarioxRelevamiento) {
                $Operario = $OperarioxRelevamiento->getOperario();
                $output[] =  $Operario;     
            }
        }
        return $output;
    }

    private function operarioNoRelacionado($Operario, $OperariosxRelevamiento){
        if($OperariosxRelevamiento){
            foreach($OperariosxRelevamiento as $OperarioxRelevamiento) {
                $OperarioActual = $OperarioxRelevamiento->getOperario();
                if($OperarioActual->getId() == $Operario->getId()) {
                    return false;
                }
            }
        }
        return true;
    }

    private function getOperariosNoRelacinadosConRelevamiento($OperariosxRelevamiento) {
        $Operarios = $this->catalogoManager->getOperarios();
        $output = [];
        foreach($Operarios as $Operario) {
            if($this->operarioNoRelacionado($Operario, $OperariosxRelevamiento)) {
                $output[] = $Operario;
            }
        }
        return $output;
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