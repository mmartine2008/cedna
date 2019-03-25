<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class AccionController extends CednaController
{
    private $accionManager;

    public function __construct($accionManager, $catalogoManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);
        
        $this->accionManager = $accionManager;
    }

    public function indexAction()
    {
        $parametros = $this->params()->fromRoute();

        $arrEntidades = $this->accionManager->getListado();
        
        $view = new ViewModel();

        $view->setVariable('arrEntidades', $arrEntidades);

        return $view;
    }

    public function altaAction(){
        $parametros = $this->params()->fromRoute();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->accionManager->procesarAlta($JsonData);

            $this->redirect()->toRoute("abm/accion", ["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('arrVariables', $this->accionManager->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/accion/alta.phtml');
        
        return $view;      
    }

    public function editarAction(){
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->accionManager->procesarAlta($JsonData, $idEntidad);

            $this->redirect()->toRoute("abm/accion", ["action" => "index"]);
        }

        $Entidad = $this->accionManager->getEntidadPorId($idEntidad);
        $view = new ViewModel();
        
        $view->setVariable('Entidad', $Entidad);
        $view->setVariable('arrVariables', $this->accionManager->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/accion/editar.phtml');
        
        return $view;      
    }

    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        $mensaje = $this->accionManager->borrarEntidad($idEntidad);

        return $this->redirect()->toRoute("abm/accion", ["action" => "index"]);
    } 
}
