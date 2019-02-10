<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigPerfilesController extends ConfiguracionController
{

    public function __construct($configuracionManager)
    {
        parent::__construct($configuracionManager);
    }

    public function indexAction()
    {
        $arrPerfiles = $this->configuracionManager->getPerfiles();

        return new ViewModel([
            'arrPerfiles' => $arrPerfiles
        ]);
    }

    public function altaAction(){
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionPerfiles($JsonData);

            $this->redirect()->toRoute("configuracion/perfiles",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('PerfilesJson', '""');
        $view->setTemplate('configuracion/config-perfiles/form-perfiles.phtml');
        
        return $view;
    }

    public function editarAction(){
        $parametros = $this->params()->fromRoute();

        $idPerfiles = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionPerfiles($JsonData, $idPerfiles);

            $this->redirect()->toRoute("configuracion/perfiles",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Perfiles = $this->configuracionManager->getPerfiles($idPerfiles);

        $view->setVariable('PerfilesJson', $Perfiles->getJSON());
        $view->setTemplate('configuracion/config-perfiles/form-perfiles.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idPerfiles = $parametros['id'];

        $mensaje = $this->configuracionManager->borrarPerfiles($idPerfiles);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/perfiles",["action" => "index"]);
    } 

}
