<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OperacionController extends CednaController
{
    private $operacionManager;

    public function __construct($operacionManager, $catalogoManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);
        
        $this->operacionManager = $operacionManager;
    }

    public function indexAction()
    {
        $parametros = $this->params()->fromRoute();

        $arrEntidades = $this->operacionManager->getListado();
        
        $view = new ViewModel();

        $view->setVariable('arrEntidades', $arrEntidades);

        return $view;
    }

    public function altaAction(){
        $parametros = $this->params()->fromRoute();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operacionManager->procesarAlta($JsonData);

            $this->redirect()->toRoute("abm/operacion", ["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('arrVariables', $this->operacionManager->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/operacion/alta.phtml');
        
        return $view;      
    }

    public function editarAction(){
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operacionManager->procesarAlta($JsonData, $idEntidad);

            $this->redirect()->toRoute("abm/operacion", ["action" => "index"]);
        }

        $Entidad = $this->operacionManager->getEntidadPorId($idEntidad);
        $view = new ViewModel();
        
        $view->setVariable('Entidad', $Entidad);
        $view->setVariable('arrVariables', $this->operacionManager->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/operacion/editar.phtml');
        
        return $view;      
    }

    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        $mensaje = $this->operacionManager->borrarEntidad($idEntidad);

        return $this->redirect()->toRoute("abm/operacion", ["action" => "index"]);
    } 
}
