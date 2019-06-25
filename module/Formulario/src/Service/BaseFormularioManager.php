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

class BaseFormularioManager {
    
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager; 
    protected $catalogoManager;
    protected $datosEmpresa;
    protected $mailManager;
    protected $translator;
    protected $datosArchivos;
    
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

    protected function getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $idPregunta) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findBy(['pregunta' => $idPregunta, 'relevamientoxSeccion' => $relevamientoxSeccion]); 
        
        return $respuesta;
    }

    protected function getRespuestaPreguntaPorRelevamientoSeccionDestino($relevamientoxSeccion, $pregunta, $destino) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findOneBy(['pregunta' => $pregunta, 'relevamientoxSeccion' => $relevamientoxSeccion, 'destino' => $destino]); 
        
        return $respuesta;
    }

    protected function puedePlanificarTarea($Relevamiento) {
        $RelevamientoxSecciones = $this->catalogoManager->getSeccionesxRelevamiento($Relevamiento);
        $HerramientasxRelevamiento = $this->catalogoManager->getHerramientasxRelevamiento($Relevamiento);
        $OperariosxRelevamiento = $this->catalogoManager->getOperariosxRelevamiento($Relevamiento);
        if(($RelevamientoxSecciones) && ($HerramientasxRelevamiento) && ($OperariosxRelevamiento)) {
            return true;
        }
        return false;
    }

    protected function todasLasPlanificacionesListas($Planificaciones) {
        foreach($Planificaciones as $Planificacion) {
            $Relevamiento = $Planificacion->getRelevamiento();
            if(($Relevamiento) &&($this->puedePlanificarTarea($Relevamiento))){
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    private function getPlanificacionesListas($Planificaciones) {
        $outputPlanificaciones = [];
        if($Planificaciones) {
            foreach($Planificaciones as $Planificacion) {
                $idRelevamiento = $Planificacion->relevamiento->id;
                $Relevamiento = $this->catalogoManager->getRelevamientos($idRelevamiento);
                if(($Relevamiento) && ($this->puedePlanificarTarea($Relevamiento))){
                    $outputPlanificaciones[] = $Planificacion; 
                } 
            }
        }  

        return $outputPlanificaciones;
    }

    protected function getTareasListasParaPlanificar($JsonArrTareas) {
        $arrTareas = json_decode($JsonArrTareas);
       
        foreach($arrTareas as $tarea) {
            $Planificaciones = $tarea->planificaciones;
            $tarea->planificaciones = $this->getPlanificacionesListas($Planificaciones);
        } 
        return json_encode($arrTareas);
    }

    protected function altaRelevamientosxSecciones($Relevamiento, $Secciones, $globales) {
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

    protected function desenlazarRelevamientosxSecciones($Relevamiento, $Secciones) {
        foreach ($Secciones as $Seccion){
            $RelevamientoxSeccion = $this->catalogoManager->getRelevamientosxSecciones($Relevamiento, $Seccion);
            if($RelevamientoxSeccion) {               
                $this->eliminarEntidad($RelevamientoxSeccion);
            }
        }
    }

    protected function altaRelevamiento($EstadoParaEditar) {
        $Relevamiento = new Relevamientos();
        $Relevamiento->setEstadoRelevamiento($EstadoParaEditar);
        
        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();

        return $Relevamiento;
    }

    /**
     * Funcion que cambia de estado el relevamiento, y lo coloca como Finalizado
     *
     * @param [Relevamientos] $Relevamiento
     * @return void
     */
    protected function finalizarRelevamiento($Relevamiento){
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
    protected function todosFirmaronRelevamiento($NodosFirmantes){
        foreach($NodosFirmantes as $NodoFirmante){
            $fechaFirma = $NodoFirmante->getFechaFirma();
            if (!isset($fechaFirma)){
                return false;
            }
        }

        return true;
    }

    /**
     * Funcion que cambia en la base de datos, el usuario 
     * que tiene que firmar el permiso de trabajo.
     *
     * @param [Nodos] $NodoFirmante
     * @param [Usuarios] $UsuarioActivo
     * @return Usuarios
     */
    protected function cambiarUsuarioFirmante($NodoFirmante, $UsuarioActivo){
        $Nodo = $NodoFirmante->getNodo();

        $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodo, $UsuarioActivo);
        $OrdenJefeInferior = $esJefeDe->getOrden() + 1;
        $esJefeDeInferior = $this->catalogoManager->getEsJefeDePorNodoOrden($Nodo, $OrdenJefeInferior);

        $NodoFirmante->setUsuarioFirmante($esJefeDeInferior->getUsuario());

        $this->entityManager->persist($NodoFirmante);
        $this->entityManager->flush();

        return $esJefeDeInferior->getUsuario();
    }

    protected function getDescripcionOpcion($opciones, $idOpcion) {
        foreach($opciones->opcion as $opcion) {
            if($opcion['id'] == $idOpcion) {
                return $opcion['descripcion'];
            }
        }
    }

    /**
     * retorna una lista de destinos con sus respectivas opciones compuestas por un id y una descripcion
     */
    protected function getListaValoresPorDestino($respuestas, $opciones){
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

    protected function modificarOpcionesDeDestino($resp, $seccion, $destino){
        if($destino['destino'] == $resp->destino."_seccion_".$seccion->id) {
            $resp->opcion = $destino['opciones'];
        }
        return $resp;
    }

    /**
     * elimina las opciones encontradas en una respuesta
     */
    protected function vaciarRespuestas($respuestasJSON) {
        foreach ($respuestasJSON as $respuesta) {
            $opciones = $respuesta->opcion;
            if($opciones) {
                $respuesta->opcion = [];
            }
        }
        return $respuestasJSON;
    }

    protected function getRespuestaUsuario($respuesta) {
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
    protected function getPreguntaJSONConRespuesta($tipoPregunta, $respuesta, $preguntaJSON, $seccion){
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

    
    protected function getJSONActualizadoPorRespuestasRelevamiento($relev) {
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


    protected function getJSONActualizadoPorFuncion($pregunta, $formJSON) {
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

    protected function getRespuestasAgrupadasPorPregunta($Respuestas) {
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

    protected function getValorFuncion($funcion, $opcion, $idRelevamientoxSeccion){
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

    protected function getRespuestaModificada($Respuesta) {
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

    protected function getArrayRespuestasModificadas($Respuestas) {
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

    protected function respuestasSonTipoPDF($Respuestas) {
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta();
            $tipoPregunta = $pregunta->getTipoPregunta();
            if($tipoPregunta->esPDF()){
                return true;
            }
            return false;
        }
    }

    protected function respuestasPertenecenASeccion($Respuestas, $idSeccion) {
        foreach($Respuestas as $Respuesta) {
            if($Respuesta->getRelevamientoxSeccion()->getSeccion()->getId() == $idSeccion){
                return true;
            }
            return false;
        }
    }

    protected function getRespuestaPorSeccion($RespuestasRelevamiento, $idSeccion){
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

    protected function getSeccionesPorFormulario($Relevamiento){
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

    protected function vaciarNodosFirmantes($Relevamiento){
        $arrNodosFirmantes = $this->catalogoManager->getNodosFirmantesPorRelevamiento($Relevamiento);

        foreach($arrNodosFirmantes as $NodoFirmanteRelevamiento){
            $this->eliminarEntidad($NodoFirmanteRelevamiento);
        }
    }

    protected function AltaNodoFirmante($Relevamiento, $id_nodo){
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

    protected function modificarNombresArchivo($idRespuestaPregunta, $nombreArchivo, $nombreReal) {
        list($pregunta, $idPregunta, $seccion, $idSeccion, $relevamiento, $idRelevamiento) = explode("_", $idRespuestaPregunta);
        $Respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccion($idRelevamiento, $idSeccion, $idPregunta);

        foreach($Respuesta as $resp) {
            $resp->setNombreArchivo($nombreArchivo);
            $resp->setDescripcion($nombreReal);
            
            $this->entityManager->persist($resp);
            $this->entityManager->flush();
        }

    }

    protected function guardarArchivos($listaArchivos, $archivo, $idRelevamiento) {
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
                    var_dump($ruta_destino_archivo);
                    $archivo_ok = move_uploaded_file($archivo['tmp_name'][$i], $ruta_destino_archivo);
                    $this->modificarNombresArchivo($listaArchivos[$i], $nombreArchivo, $nombreReal);
                }
            }
        }
    }

    protected function eliminarEntidad($Entidad) {
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

    protected function eliminarRespuestasSelectores($preguntaEntidad, $relevamientoxSeccion) {
        $entidades = $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $preguntaEntidad);
        foreach($entidades as $entidad) {
            $this->eliminarEntidad($entidad);
        }
    }

    protected function altaRespuestaSegunTipoRespuesta($preguntaEntidad, $relevamientoxSeccion, $respuesta){
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

    protected function eliminarRespuestasSinResponder($Pregunta, $relevamientoxSeccion) {
        $Respuestas = $this->getRespuestaPreguntaPorRelevamientoSeccion($relevamientoxSeccion, $Pregunta);
        foreach($Respuestas as $Respuesta) {
            $this->eliminarEntidad($Respuesta);
        } 
    }

    protected function altaRespuestasFormulario($datos, $Relevamiento) {
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

    protected function seccionNoRelacionada($Seccion, $RelevamientosxSecciones){
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

    protected function getSeccionesGlobalesAlRelevamento($Tarea){
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

    protected function seccionPerteneceAGlobales($seccionesGlobales, $Seccion) {
        foreach($seccionesGlobales as $seccionGlobal) {
            if($seccionGlobal->getId() == $Seccion->getId()) {
                return true;
            }
        }
        return false;
    }

    protected function getSeccionesNoRelacinadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales) {
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

    protected function getSeccionesRelacionadasConRelevamiento($RelevamientosxSecciones, $seccionesGlobales) {
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

    protected function desenlazarHerramientasDeRelevamiento($Relevamiento, $Herramientas) {
        foreach ($Herramientas as $Herramienta){
            $HerramientaxRelevamiento = $this->catalogoManager->getHerramientaxRelevamiento($Herramienta, $Relevamiento);
            
            if($HerramientaxRelevamiento) {    
                $this->eliminarEntidad($HerramientaxRelevamiento);  
            }
        }
    }

    protected function altaHerramientasxRelevamiento($Relevamiento, $Herramientas) {
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

    protected function getHerramientasRelacionadasConRelevamiento($HerramientasxRelevamiento) {
        $output = [];
        if($HerramientasxRelevamiento) {
            foreach($HerramientasxRelevamiento as $herramientaxRelevamiento) {
                $herramienta = $herramientaxRelevamiento->getHerramienta();
                $output[] =  $herramienta;     
            }
        }
        return $output;
    }

    protected function herramientaNoRelacionada($Herramienta, $HerramientasxRelevamiento){
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

    protected function getHerramientasNoRelacinadasConRelevamiento($HerramientasxRelevamiento) {
        $Herramientas = $this->catalogoManager->getHerramientasDeTrabajo();
        $output = [];
        foreach($Herramientas as $Herramienta) {
            if($this->herramientaNoRelacionada($Herramienta, $HerramientasxRelevamiento)) {
                $output[] = $Herramienta;
            }
        }
        return $output;
    }
  
    protected function desenlazarOperariosDeRelevamiento($Relevamiento, $Operarios) {
        foreach ($Operarios as $Operario){
            $OperarioxRelevamiento = $this->catalogoManager->getOperarioxRelevamiento($Operario, $Relevamiento);
            if($OperarioxRelevamiento) {               
                $this->eliminarEntidad($OperarioxRelevamiento);
            }
        }
    }

    protected function altaOperariosxRelevamiento($Relevamiento, $Operarios) {
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

    protected function getOperariosRelacionadosConRelevamiento($OperariosxRelevamiento) {
        $output = [];
        if($OperariosxRelevamiento) {
            foreach($OperariosxRelevamiento as $OperarioxRelevamiento) {
                $Operario = $OperarioxRelevamiento->getOperario();
                $output[] =  $Operario;     
            }
        }
        return $output;
    }

    protected function operarioNoRelacionado($Operario, $OperariosxRelevamiento){
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

    protected function getOperariosNoRelacinadosConRelevamiento($OperariosxRelevamiento) {
        $Operarios = $this->catalogoManager->getOperarios();
        $output = [];
        foreach($Operarios as $Operario) {
            if($this->operarioNoRelacionado($Operario, $OperariosxRelevamiento)) {
                $output[] = $Operario;
            }
        }
        return $output;
    }
}