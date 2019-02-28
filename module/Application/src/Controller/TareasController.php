<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class TareasController extends CednaController
{
    private $tareasManager;

    public function __construct($catalogoManager, $userSessionManager, $tareasManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->tareasManager = $tareasManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('tareas');
        
        $arrTareasJSON = $this->catalogoManager->getArrTareasJSON();

        return new ViewModel([
            'arrTareasJSON' => $arrTareasJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('tareas - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $userName = $this->userSessionManager->getUserName();
            $this->tareasManager->altaEdicionTareas($JsonData, $userName);

            $this->redirect()->toRoute("tareas",["action" => "index"]);
        }
        
        $arrNodosJSON = $this->catalogoManager->getArrNodosJSON();
        $arrFormularioJSON = $this->catalogoManager->getArrFormularioJSON();

        $view = new ViewModel();
        
        $view->setVariable('TareasJson', '""');
        $view->setVariable('arrNodosJSON', $arrNodosJSON);
        $view->setVariable('arrFormularioJSON', $arrFormularioJSON);
        $view->setTemplate('application/tareas/form-tareas.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('tareas - edicion');
        $parametros = $this->params()->fromRoute();

        $idTareas = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $userName = $this->userSessionManager->getUserName();
            $this->tareasManager->altaEdicionTareas($JsonData, $userName, $idTareas);

            $this->redirect()->toRoute("tareas",["action" => "index"]);
        }

        $arrNodosJSON = $this->catalogoManager->getArrNodosJSON();
        $arrFormularioJSON = $this->catalogoManager->getArrFormularioJSON();

        $view = new ViewModel();
        
        $Tareas = $this->catalogoManager->getTareas($idTareas);

        $view->setVariable('TareasJson', $Tareas->getJSON());
        $view->setVariable('arrNodosJSON', $arrNodosJSON);
        $view->setVariable('arrFormularioJSON', $arrFormularioJSON);
        $view->setTemplate('application/tareas/form-tareas.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idTareas = $parametros['id'];

        $mensaje = $this->tareasManager->borrarTareas($idTareas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("tareas",["action" => "index"]);
    } 

}
