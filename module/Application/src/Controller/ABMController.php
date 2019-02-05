<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ABMController extends AbstractActionController
{
    private $accionManager;
    private $operacionManager;
    private $usuariosManager;
    private $perfilesManager;
    private $operacionAccionPerfilManager;

    public function __construct($accionManager, $operacionManager, $usuariosManager,
                                    $perfilesManager, $operacionAccionPerfilManager)
    {
        $this->accionManager = $accionManager;
        $this->operacionManager = $operacionManager;
        $this->usuariosManager = $usuariosManager;
        $this->perfilesManager = $perfilesManager;
        $this->operacionAccionPerfilManager = $operacionAccionPerfilManager;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function abmAction()
    {
        return new ViewModel();
    }

    
    public function listarAction()
    {
        $parametros = $this->params()->fromRoute();

        $nombreEntidad = $parametros['entidad'];
        $manager = $nombreEntidad.'Manager';

        //construir manager dinamicamente
        $arrEntidades = $this->$manager->getListado();
        
        $view = new ViewModel();

        $view->setVariable('arrEntidades', $arrEntidades);

        $view->setTemplate('application/abm/'.$nombreEntidad.'.phtml');
        return $view;
    }

    public function altaAction(){
        $parametros = $this->params()->fromRoute();

        $nombreEntidad = $parametros['entidad'];

        $manager = $nombreEntidad.'Manager';

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->$manager->procesarAlta($JsonData);

            $this->redirect()->toRoute("abm/entidad",["entidad" => $nombreEntidad, "action" => "listar"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('arrVariables', $this->$manager->getArrVariablesAltaEntidad());
        $view->setTemplate('application/abm/alta-'.$nombreEntidad.'.phtml');
        
        return $view;      
    }
}
