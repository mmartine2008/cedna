<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigUsuariosController extends ConfiguracionController
{

    public function __construct($configuracionManager)
    {
        parent::__construct($configuracionManager);
    }

    public function indexAction()
    {
        $arrUsuarios = $this->configuracionManager->getUsuarios();

        return new ViewModel([
            'arrUsuarios' => $arrUsuarios
        ]);
    }

    public function altaAction(){
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionUsuarios($JsonData);

            $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
        }

        $arrPerfiles = $this->configuracionManager->getPerfiles();

        $view = new ViewModel();
        
        $view->setVariable('UsuariosJson', '""');
        $view->setVariable('arrPerfiles', $arrPerfiles);
        $view->setTemplate('configuracion/config-usuarios/form-usuarios.phtml');
        
        return $view;
    }

    public function editarAction(){
        $parametros = $this->params()->fromRoute();

        $idUsuarios = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionUsuarios($JsonData, $idUsuarios);

            $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
        }

        $arrPerfiles = $this->configuracionManager->getPerfiles();

        $view = new ViewModel();
        
        $Usuarios = $this->configuracionManager->getUsuarios($idUsuarios);

        $view->setVariable('UsuariosJson', $Usuarios->getJSON());
        $view->setVariable('arrPerfiles', $arrPerfiles);
        $view->setTemplate('configuracion/config-usuarios/form-usuarios.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idUsuarios = $parametros['id'];

        $mensaje = $this->configuracionManager->borrarUsuarios($idUsuarios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
    } 

}
