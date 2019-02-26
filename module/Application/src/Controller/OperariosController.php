<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OperariosController extends CednaController
{
    private $operariosManager;

    public function __construct($catalogoManager, $userSessionManager, $operariosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager);

        $this->operariosManager = $operariosManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('operarios');
        
        $arrOperariosJSON = $this->catalogoManager->getArrOperariosJSON();

        return new ViewModel([
            'arrOperariosJSON' => $arrOperariosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('operarios - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operariosManager->altaEdicionOperarios($JsonData);

            $this->redirect()->toRoute("operarios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('OperariosJson', '""');
        $view->setTemplate('application/operarios/form-operarios.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('operarios - edicion');
        $parametros = $this->params()->fromRoute();

        $idOperarios = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->operariosManager->altaEdicionOperarios($JsonData, $idOperarios);

            $this->redirect()->toRoute("operarios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Operarios = $this->catalogoManager->getOperarios($idOperarios);

        $view->setVariable('OperariosJson', $Operarios->getJSON());
        $view->setTemplate('application/operarios/form-operarios.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idOperarios = $parametros['id'];

        $mensaje = $this->operariosManager->borrarOperarios($idOperarios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("operarios",["action" => "index"]);
    } 

}
