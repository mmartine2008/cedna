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

    private $configUsuariosManager;

    public function __construct($catalogoManager, $configUsuariosManager, $userSessionManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->configUsuariosManager = $configUsuariosManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('usuarios');
        $arrUsuariosJSON = $this->catalogoManager->getArrEntidadJSON('Usuarios');

        return new ViewModel([
            'arrUsuariosJSON' => $arrUsuariosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('usuarios - alta');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configUsuariosManager->altaEdicionUsuarios($JsonData);

            $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
        }

        $arrPerfiles = $this->catalogoManager->getPerfiles();

        $view = new ViewModel();
        
        $view->setVariable('UsuariosJson', '""');
        $view->setVariable('arrPerfiles', $arrPerfiles);
        $view->setVariable('nombreUsuarioValido', false);
        $view->setTemplate('configuracion/config-usuarios/form-usuarios.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('usuarios - edicion');
        $parametros = $this->params()->fromRoute();

        $idUsuarios = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configUsuariosManager->altaEdicionUsuarios($JsonData, $idUsuarios);

            $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
        }

        $arrPerfiles = $this->catalogoManager->getPerfiles();

        $view = new ViewModel();
        
        $Usuarios = $this->catalogoManager->getUsuarios($idUsuarios);

        $view->setVariable('UsuariosJson', $Usuarios->getJSON());
        $view->setVariable('arrPerfiles', $arrPerfiles);
        $view->setVariable('nombreUsuarioValido', true);
        $view->setTemplate('configuracion/config-usuarios/form-usuarios.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idUsuarios = $parametros['id'];

        $mensaje = $this->configUsuariosManager->borrarUsuarios($idUsuarios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/usuarios",["action" => "index"]);
    } 

    public function nombreUsuarioValidoAction(){
        $parametros = $this->params()->fromRoute();
        $futuroNombreUsuario = $parametros['id'];

        $esValido = $this->configUsuariosManager->comprobarNombreUsuarioEsValido($futuroNombreUsuario);

        $view = new ViewModel();
        
        $view->setVariable('mostrarJson', json_encode(['esValido' => $esValido]));
        $view->setTerminal(true);
        $view->setTemplate('formulario/formulario/mostrarJSON.phtml');
        
        return $view;
    }
}
