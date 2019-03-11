<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class PlanificacionController extends CednaController
{
    private $tareasManager;

    public function __construct($catalogoManager, $userSessionManager, $tareasManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->tareasManager = $tareasManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('planificacion de tareas');
        
        $arrTareasJSON = $this->catalogoManager->getArrEntidadJSON('Tareas');

        return new ViewModel([
            'arrTareasJSON' => $arrTareasJSON
        ]);
    }
    
    public function asignarAction(){
        $this->cargarAccionesDisponibles('planificacion - asignar');

        $parametros = $this->params()->fromRoute();
        $idTareas = $parametros['id'];
        $Tareas = $this->catalogoManager->getTareas($idTareas);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $userName = $this->userSessionManager->getUserName();
            $this->tareasManager->guardarPlanificacionTarea($JsonData, $Tareas);

            $this->redirect()->toRoute("planificacion", ["action" => "index"]);
        }

        $arrTipoPlanificacionJSON = $this->catalogoManager->getArrEntidadJSON('TipoPlanificacion');

        $view = new ViewModel();
        
        $view->setVariable('TareaJSON', $Tareas->getJSON());
        $view->setVariable('arrTipoPlanificacionJSON', $arrTipoPlanificacionJSON);
        $view->setTemplate('application/planificacion/form-planificacion-por-dia.phtml');
        
        return $view;
    }

}
