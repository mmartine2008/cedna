<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OrganigramaController extends CednaController
{
    private $organigramaManager;

    public function __construct($catalogoManager, $userSessionManager, $organigramaManager)
    {
        parent::__construct($catalogoManager, $userSessionManager);

        $this->organigramaManager = $organigramaManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('organigrama');
        
        $arrNodosJSON = $this->catalogoManager->getArrNodosJSON();

        return new ViewModel([
            'arrNodosJSON' => $arrNodosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('organigrama - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->organigramaManager->altaEdicionNodos($JsonData);

            $this->redirect()->toRoute("organigrama", ["action" => "index"]);
        }

        $arrTipoNodo = $this->catalogoManager->getTipoNodo();
        $arrNodos  = $this->catalogoManager->getNodos();

        $view = new ViewModel();
        
        $view->setVariable('NodosJson', '""');
        $view->setVariable('arrTipoNodo', $arrTipoNodo);
        $view->setVariable('arrNodos', $arrNodos);
        $view->setTemplate('application/organigrama/form-nodos.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('organigrama - edicion');
        $parametros = $this->params()->fromRoute();

        $idNodos = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->organigramaManager->altaEdicionNodos($JsonData, $idNodos);

            $this->redirect()->toRoute("organigrama", ["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Nodos = $this->catalogoManager->getNodos($idNodos);

        $arrTipoNodo = $this->catalogoManager->getTipoNodo();
        $arrNodos  = $this->catalogoManager->getNodos();

        $view->setVariable('NodosJson', $Nodos->getJSON());
        $view->setVariable('arrTipoNodo', $arrTipoNodo);
        $view->setVariable('arrNodos', $arrNodos);
        $view->setTemplate('application/organigrama/form-nodos.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idNodos = $parametros['id'];

        $mensaje = $this->organigramaManager->borrarNodos($idNodos);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("organigrama", ["action" => "index"]);
    } 

}
