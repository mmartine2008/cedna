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

    public function __construct($catalogoManager, $userSessionManager, $operariosManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->operariosManager = $operariosManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('operarios');
        
        $OperacionesJSON = $this->recuperarOperacionesIniciales('operarios');
        
        return new ViewModel(['OperacionesJSON' => $OperacionesJSON]);
    }

    public function listarAction(){
        $this->cargarAccionesDisponibles('operarios - listar');
        
        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        $arrOperariosJSON = $this->operariosManager->getArrOperariosJSON($UsuarioActivo);

        return new ViewModel([
            'arrOperariosJSON' => $arrOperariosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('operarios - alta');

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operariosManager->altaEdicionOperarios($JsonData, $UsuarioActivo);

            $this->redirect()->toRoute("operarios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('OperariosJson', '""');
        $view->setTemplate('application/operarios/alta-operarios.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('operarios - edicion');
        $parametros = $this->params()->fromRoute();

        $idOperarios = $parametros['id'];

        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->operariosManager->altaEdicionOperarios($JsonData, $UsuarioActivo, $idOperarios);

            $this->redirect()->toRoute("operarios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Operarios = $this->catalogoManager->getOperarios($idOperarios);

        $view->setVariable('OperariosJson', $Operarios->getJSON());
        $view->setTemplate('application/operarios/editar-operarios.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idOperarios = $parametros['id'];

        $mensaje = $this->operariosManager->borrarOperarios($idOperarios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("operarios",["action" => "index"]);
    }

    public function induccionesAction(){
        $this->cargarAccionesDisponibles('operarios - inducciones');

        $arrInduccionesJSON = $this->catalogoManager->getArrEntidadJSON('Inducciones');

        return new ViewModel([
            'arrInduccionesJSON' => $arrInduccionesJSON
        ]);
    }

    public function cargarInduccionAction(){
        $this->cargarAccionesDisponibles('operarios - cargar induccion');
        $parametros = $this->params()->fromRoute();

        $idInduccion = $parametros['id'];
        $Induccion = $this->catalogoManager->getInducciones($idInduccion);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->operariosManager->cargarInduccionesAOperarios($JsonData, $Induccion);

            $this->redirect()->toRoute("operarios",["action" => "inducciones"]);
        }

        $userName = $this->userSessionManager->getUserName();

        $arrOperariosJSON = $this->operariosManager->getArrOperariosJSON();

        return new ViewModel([
            'arrOperariosJSON' => $arrOperariosJSON,
            'InduccionJSON' => $Induccion->getJSON()
        ]);
    }

}
