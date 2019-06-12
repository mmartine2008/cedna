<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class HerramientasController extends CednaController
{
    private $herramientasManager;

    public function __construct($catalogoManager, $userSessionManager, $translator, $permisosManager, $herramientasManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->herramientasManager = $herramientasManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('herramientas');
        
        $arrHerramientasJSON = $this->catalogoManager->getArrEntidadJSON('HerramientasDeTrabajo');

        return new ViewModel([
            'arrHerramientasJSON' => $arrHerramientasJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('herramientas - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->herramientasManager->altaEdicionHerramientas($JsonData);

            $this->redirect()->toRoute("herramientas",["action" => "index"]);
        }
        
        $view = new ViewModel();
        $view->setVariable('HerramientaJson', '""');
        $view->setTemplate('application/herramientas/form-herramientas.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('herramientas - edicion');
        $parametros = $this->params()->fromRoute();

        $idHerramienta = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->herramientasManager->altaEdicionHerramientas($JsonData, $idHerramienta);

            $this->redirect()->toRoute("herramientas",["action" => "index"]);
        }
        $view = new ViewModel();
        
        $Herramienta = $this->catalogoManager->getHerramientasDeTrabajo($idHerramienta);

        $view->setVariable('HerramientaJson', $Herramienta->getJSON());
        $view->setTemplate('application/herramientas/form-herramientas.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idHerramientas = $parametros['id'];

        $mensaje = $this->herramientasManager->borrarHerramientas($idHerramientas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("herramientas",["action" => "index"]);
    }

    public function asignacionAction(){
        $this->cargarAccionesDisponibles('herramientas - asignacion');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('formularios - asignacion');

        $arrTareasJSON = $this->catalogoManager->getArrEntidadJSON('Tareas');

        $view = new ViewModel();
        $view->setVariable('OperacionesJSON', $OperacionesJSON);
        $view->setVariable('arrTareasJSON',  $arrTareasJSON);
        $view->setTemplate('formulario/asignar-herramentas.phtml');

        return $view;
    }

    /**
     * Accion para asignarle a la planificacion un formulario especifico.
     *
     * @return ViewModel
     */
    public function asignarAction(){
        $this->cargarAccionesDisponibles('herramientas - asignar');

        $parametros = $this->params()->fromRoute();
        $idPlanificacion = $parametros['id'];
        $Planificacion = $this->catalogoManager->getPlanificaciones($idPlanificacion);
        $Tareas = $Planificacion->getTarea();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->FormularioManager->asignarSeccionesAPlanificacion($JsonData, $Planificacion, $Tareas);

            $this->redirect()->toRoute("herramientas", ["action" => "asignacion"]);
        }

        $arrSeccionesJSON = $this->FormularioManager->getSeccionesPorRelevamiento($Planificacion->getRelevamiento(), $Tareas);
        
        $view = new ViewModel();
        
        $view->setVariable('PlanificacionJSON', $Planificacion->getJSON());
        $view->setVariable('TareaJSON', $Tareas->getJSON());
        $view->setVariable('arrSeccionesJSON', $arrSeccionesJSON);
        $view->setTemplate('formulario/asignar-herramientas.phtml');
        
        return $view;
    }
}
