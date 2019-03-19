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


class FormularioManager {
    
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

    public function getPregunta($id) {
        $pregunta = $this->entityManager->getRepository(Pregunta::class)
                                            ->findOneBy(['id' => $id]); 
        return $pregunta;
    }

    public function getSeccion($id) {
        $seccion = $this->entityManager->getRepository(Seccion::class)
                                            ->findOneBy(['id' => $id]); 
        return $seccion;
    }

    public function getFormulario($id) {
        $formulario = $this->entityManager->getRepository(Formulario::class)
                                            ->findOneBy(['id' => $id]); 
        return $formulario;
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

    public function getSeccionesxFormulario($formulario){
        $Secciones = $this->entityManager->getRepository(Seccion::class)
                                            ->findBy(['formulario' => $formulario]); 
        return $Secciones;
    }

    /**
     * Funcion que asignar un formulario a una planificacion.
     */
    public function asignarFormularioAPlanificacion($JsonData, $Planificacion){
        $Formulario = $this->catalogoManager->getFormulario($JsonData->formulario->id);

        $Relevamiento = $Planificacion->getRelevamiento();

        if ($Relevamiento){
            $Relevamiento->setFormulario($Formulario);
            $this->entityManager->persist($Relevamiento);
        }else{
            $EstadoParaEditar = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_PARA_EDITAR);
            
            $Relevamiento = new Relevamientos();
            $Relevamiento->setFormulario($Formulario);
            $Relevamiento->setEstadoRelevamiento($EstadoParaEditar);
            
            $this->entityManager->persist($Relevamiento);
            $this->entityManager->flush();

            
            $Planificacion->setRelevamiento($Relevamiento);
            $this->entityManager->persist($Planificacion);
        }

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
        }
    }

    /**
     * Funcion que se encarga de procesar la delegacion de la 
     * firma del usuario, hacia otro usuario que tenga un orden siguiente
     * en la jerarquia del nodo.
     *
     * @param [integer] $idPlanificacion
     * @param [Usuarios] $UsuarioActivo
     * @return void
     */
    public function delegarFirmaFormulario($idPlanificacion, $UsuarioActivo){
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();

        $NodosFirmantes = $Relevamiento->getNodosFirmantesRelevamiento();

        foreach($NodosFirmantes as $NodoFirmante){
            if ($NodoFirmante->getUsuarioFirmante() == $UsuarioActivo){
                
                $this->cambiarUsuarioFirmante($NodoFirmante, $UsuarioActivo);
                break;
            }
        }
    }

    /**
     * Funcion que cambia en la base de datos, el usuario 
     * que tiene que firmar el permiso de trabajo.
     *
     * @param [Nodos] $NodoFirmante
     * @param [Usuarios] $UsuarioActivo
     * @return void
     */
    private function cambiarUsuarioFirmante($NodoFirmante, $UsuarioActivo){
        $Nodo = $NodoFirmante->getNodo();

        $esJefeDe = $this->catalogoManager->getEsJefeDePorNodoUsuario($Nodo, $UsuarioActivo);
        $OrdenJefeInferior = $esJefeDe->getOrden() + 1;
        $esJefeDeInferior = $this->catalogoManager->getEsJefeDePorNodoOrden($Nodo, $OrdenJefeInferior);

        $NodoFirmante->setUsuarioFirmante($esJefeDeInferior->getUsuario());

        $this->entityManager->persist($NodoFirmante);
        $this->entityManager->flush();
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

    public function getPreguntasxFormulario($formulario) {
        $secciones = $this->getSeccionesxFormulario($formulario);
        $arregloPreg = [];
        foreach($secciones as $seccion){
            $preguntasxSeccion = $this->getPreguntasxSeccion($seccion);
            foreach($preguntasxSeccion as $pregunta) {
                $arregloPreg[] = $pregunta->getPregunta();
            }
        }
        return $arregloPreg;
    }

    public function getOpcionesFuncion($pregunta) {
        $strinfFuncion = $pregunta->getFuncion();
        $opciones = $this->catalogoManager->{$strinfFuncion}();
        return $opciones;
    }

    public function getJSONModificadoSelectSimple($pregunta, $form) {
        $secc = $form->secciones;
        foreach($secc as $seccion) {
            $preguntas = $seccion->preguntas;
            foreach($preguntas as $preguntaJSON) {
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta);
                    $preguntaJSON->opciones = $opciones;
                }
            }
        }
        return $form;
    }

    public function getJSONModificadoSelectMultiple($pregunta, $form) {
        $secciones = $form->secciones;
        foreach($secciones as $seccion) {
            $preguntas = $seccion->preguntas;
            foreach($preguntas as $preguntaJSON) {
                if($preguntaJSON->idPregunta == $pregunta->getId()) {
                    $opciones = $this->getOpcionesFuncion($pregunta);
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
        return $form;
    }

    private function getRespuestaPreguntaPorRelevamientoSeccion($idRelevamiento, $idSeccion, $idPregunta) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findBy(['pregunta' => $idPregunta, 'seccion' => $idSeccion, 'relevamiento' => $idRelevamiento]); 
        
        return $respuesta;
    }

    private function getRespuestaPreguntaPorRelevamientoSeccionDestino($relevamiento, $seccion, $pregunta, $destino) {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)
                    ->findOneBy(['pregunta' => $pregunta, 'seccion' => $seccion, 'relevamiento' => $relevamiento, 'destino' => $destino]); 
        
        return $respuesta;
    }

    private function getDescripcionOpcion($opciones, $idOpcion) {
        foreach($opciones->opcion as $opcion) {
            if($opcion['id'] == $idOpcion) {
                return $opcion['descripcion'];
            }
        }
    }

    private function getListaValoresPorDesino($respuestas, $opciones, $idSeccion, $idPregunta){
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

    private function vaciarRespuestas($respuestasJSON) {
        foreach ($respuestasJSON as $respuesta) {
            $opciones = $respuesta->opcion;
            if($opciones) {
                $respuesta->opcion = [];
            }
        }
        return $respuestasJSON;
    }

    private function getPreguntaJSONConRespuesta($tipoPregunta, $respuesta, $preguntaJSON, $seccion){
        if($tipoPregunta->descripcion == 'multiple'){
            $listaDestinos = $this->getListaValoresPorDesino($respuesta, $preguntaJSON->respuesta[0], $seccion->id, $preguntaJSON->idPregunta);
            $preguntaJSON->respuesta = $this->vaciarRespuestas($preguntaJSON->respuesta);
            foreach($listaDestinos as $destino) {
                foreach($preguntaJSON->respuesta as $resp) {
                    $resp = $this->modificarOpcionesDeDestino($resp, $seccion, $destino);
                }
            }
        } else {
                if($respuesta[0]->getDescripcion()) {
                    $preguntaJSON->respuesta = $respuesta[0]->getDescripcion();
                } else {
                    $preguntaJSON->respuesta = $respuesta[0]->getOpcion();
                }
        }
        return $preguntaJSON;
    }

    private function getJSONActualizadoPorRespuestasRelevamiento($form, $idRelevamiento) {
        $secciones = $form->secciones;
        foreach($secciones as $seccion) {
            $preguntas = $seccion->preguntas;
            foreach($preguntas as $preguntaJSON) {
                $tipoPregunta = $preguntaJSON->tipoPregunta;
                $respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccion($idRelevamiento, $seccion->id, $preguntaJSON->idPregunta);
                if($respuesta) {
                    $preguntaJSON = $this->getPreguntaJSONConRespuesta($tipoPregunta, $respuesta, $preguntaJSON, $seccion);
                    $preguntasGeneradoras = $preguntaJSON->preguntasGeneradas;
                    if($preguntasGeneradoras) {
                        foreach($preguntasGeneradoras as $preguntaGeneradora) {
                            $opcionGeneradora = $preguntaGeneradora->opcion;
                            if($preguntaJSON->respuesta == $opcionGeneradora->id) {
                                $respuestaPregGeneradora= $this->getRespuestaPreguntaPorRelevamientoSeccion($idRelevamiento, $seccion->id, $preguntaGeneradora->preguntaGenerada->idPregunta);
                                $preguntaGeneradora->preguntaGenerada = $this->getPreguntaJSONConRespuesta($preguntaGeneradora->preguntaGenerada->tipoPregunta, $respuestaPregGeneradora, $preguntaGeneradora->preguntaGenerada, $seccion);
                            }
                        }
                    }
                }
            }
        } 
        return $form;
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

    public function getJSONActualizado($formulario, $Relevamiento){
        $preguntas = $this->getPreguntasxFormulario($formulario);
        $JSON = $formulario->getJSON();
        $formJSON = json_decode($JSON);
        foreach($preguntas as $pregunta) {
            $formJSON = $this->getJSONActualizadoPorFuncion($pregunta, $formJSON);
        }

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
        $Respuestas = $this->entityManager->getRepository(Respuesta::class)
                            ->findAll(); 
        $output = [];
        foreach($Respuestas as $Respuesta) {
            if ($Respuesta->getRelevamiento()->getId() == $Relevamiento->getId()) {
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

    private function getValorFuncion($funcion, $opcion){
        $opciones = $this->catalogoManager->{$funcion}();
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
                $valorOpcion = $this->getValorFuncion($pregunta->funcion, $respuestaDec->opcion);
            } else {
                $valorOpcion = $this->getOpcion($respuestaDec->opcion)->getDescripcion();
            }
            $respuestaDec->respuesta = $valorOpcion;
        }
       
        return json_decode(json_encode($respuestaDec), true);
    }

    private function getArrayRespuestasModificadas($Respuestas) {
        $output = [];
        $destinoAcum = "";
        $ArrayAcum = [];
        foreach($Respuestas as $Respuesta){
            $destino = $Respuesta->getDestino();
            if($destinoAcum != $destino) {
                if($ArrayAcum) {
                    $output[] = ['destino' => $destinoAcum,
                                'respuestas' => $ArrayAcum];
                    
                    $ArrayAcum = [];
                }
                $destinoAcum = $destino;
            }
            $ArrayAcum[] = $this->getRespuestaModificada($Respuesta);
        }
        $output[] = ['destino' => $destinoAcum,
                    'respuestas' => $ArrayAcum];
        
        return $output;
    }

    public function getRespuestasPorPreguntas($Respuestas) {
        $output = [];
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta()->getDescripcion(); 
            $destinos = $Respuesta->getPregunta()->getTipoPregunta()->esPeguntaMultiple();
            if(!$destinos) {
                $respuestaOutput = $this->getRespuestaModificada($Respuesta);
            }
        }

        if($destinos) {
            $respuestaOutput = $this->getArrayRespuestasModificadas($Respuestas);
        }

        $output[]= ['descripcionPregunta' => $pregunta,
                    'poseeDestinos' => $destinos,
                    'respuesta' => $respuestaOutput];
        return $output;
    } 


    private function respuestasSonTipoArchivo($Respuestas) {
        foreach($Respuestas as $Respuesta) {
            $pregunta = $Respuesta->getPregunta();
            $tipoPregunta = $pregunta->getTipoPregunta();
            if($tipoPregunta->getDescripcion() == 'file'){
                return true;
            }
            return false;
        }
    }

    private function respuestasPertenecenASeccion($Respuestas, $idSeccion) {
        foreach($Respuestas as $Respuesta) {
            if($Respuesta->getSeccion()->getId() == $idSeccion){
                return true;
            }
            return false;
        }
    }

    private function getRespuestaPorSeccion($RespuestasRelevamiento, $idSeccion){
        $respuestas = [];
        foreach($RespuestasRelevamiento as $Respuestas){
            if($this->respuestasPertenecenASeccion($Respuestas, $idSeccion)){
                if(!$this->respuestasSonTipoArchivo($Respuestas)){
                    $respuestas[] = $this->getRespuestasPorPreguntas($Respuestas);
                }
            } 
        } 
        
        return $respuestas ;
    } 

    private function getSeccionesPorFormulario($Relevamiento){
        $RespuestasRelevamiento = $this->getRespuestasSegunRelevamiento($Relevamiento);
        $secciones = $Relevamiento->getFormulario()->getSecciones();
        foreach($secciones as $seccion) {
            $output[] = ['idSeccion' => $seccion->getId(), 'descripcionSeccion' =>$seccion->getDescripcion(), 
                    'respuestas' => $this->getRespuestaPorSeccion($RespuestasRelevamiento, $seccion->getId())];
        }
        return $output;
    }

    public function getRespuestas($Relevamiento){
        $output = [];
       
        $output = ['idRelevamiento' =>$Relevamiento->getId(), 
                    'descripcionFormulario' => $Relevamiento->getFormulario()->getNombre(),
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

    public function altaRespuesta($pregunta, $seccion, $relevamiento, $respuesta, $destino, $opcion) {
        $Entidad = new Respuesta();
        $Entidad->setPregunta($pregunta);
        $Entidad->setSeccion($seccion);
        $Entidad->setRelevamiento($relevamiento);
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

    public function altaEdicionRespuesta($pregunta, $seccion, $relevamiento, $respuesta, $destino, $opcion) {
        $Respuesta = $this->getRespuestaPreguntaPorRelevamientoSeccionDestino($relevamiento, $seccion, $pregunta, $destino);
        if(($Respuesta)&& (!$destino)) { //var
            $this->actualizarRespuesta($Respuesta, $respuesta, $destino, $opcion);
        } else {

            $this->altaRespuesta($pregunta, $seccion, $relevamiento, $respuesta, $destino, $opcion);
        }
    }

    public function altaRespuestasDestino($pregunta, $seccion, $Relevamiento, $respuesta, $listaDestinos){
        foreach($listaDestinos as $item) {
            $destino = $item[0];
            $opcion = $item[1]->id;
            $this->altaEdicionRespuesta($pregunta, $seccion, $Relevamiento, $respuesta, $destino, $opcion);
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

    private function elminarEntidad($Entidad) {
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

    private function eliminarRespuestasSelectores($preguntaEntidad, $seccionEnt, $Relevamiento) {
        $entidades = $this->getRespuestaPreguntaPorRelevamientoSeccion($Relevamiento, $seccionEnt, $preguntaEntidad);
        foreach($entidades as $entidad) {
            $this->elminarEntidad($entidad);
        }
    }

    public function altaRespuestaSegunTipoRespuesta($preguntaEntidad, $seccionEnt, $Relevamiento, $respuesta){
        $listaOpcionDestino = $this->getListaOpcionDestinoPregunta($preguntaEntidad, $respuesta);
        if ($listaOpcionDestino){
            $this->eliminarRespuestasSelectores($preguntaEntidad, $seccionEnt, $Relevamiento);
            $this->altaRespuestasDestino($preguntaEntidad, $seccionEnt, $Relevamiento, $respuesta, $listaOpcionDestino);
        } else {
            $opcion = null;
            if ($preguntaEntidad->tieneOpciones()) {
                $opcion = $respuesta;
            }   
            $this->altaEdicionRespuesta($preguntaEntidad, $seccionEnt, $Relevamiento, $respuesta, null, $opcion);
        }
    }

    public function altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento){
        $respuesta = $pregunta->respuesta;
        if ($this->tieneRespuesta($respuesta)){
            $idPregunta = $pregunta->idPregunta;
            $preguntaEntidad = $this->getPregunta($idPregunta);
            $this->altaRespuestaSegunTipoRespuesta($preguntaEntidad, $seccionEnt, $Relevamiento, $respuesta);
        }
    }

    public function altaRespuestaPreguntasGeneradas($preguntasGeneradas, $seccionEnt, $Relevamiento){
        foreach($preguntasGeneradas as $preguntaGenerada) {
            if($preguntaGenerada->estado == "block"){
                $pregunta = $preguntaGenerada->preguntaGenerada;
                $this->altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento);
            }
        }
    }

    public function altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento){
        $idSeccion = $seccion->id;
        $seccionEnt = $this->getSeccion($idSeccion);
        foreach ($seccion->preguntas as $pregunta) {
            $this->altaRespuestaDePregunta($pregunta, $seccionEnt, $Relevamiento);
            if($pregunta->preguntasGeneradas) {
                $this->altaRespuestaPreguntasGeneradas($pregunta->preguntasGeneradas, $seccionEnt, $Relevamiento);
            }
        }
    }

    public function altaRespuestasFormulario($datos, $idPlanificacion) {
        $secciones = $datos->secciones;
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Relevamiento = $Planificacion->getRelevamiento();
        foreach ($secciones as $seccion) {
            $this->altaRespuestaDePreguntaPorSeccion($seccion, $Relevamiento);
        }

        $EstadoEditado = $this->catalogoManager->getEstadosRelevamiento(EstadosRelevamiento::ID_EDITADO);
        $Relevamiento->setEstadoRelevamiento($EstadoEditado);

        $this->entityManager->persist($Relevamiento);
        $this->entityManager->flush();
    }

    
}