<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OperacionAccionPerfilController extends CednaController
{
    private $operacionAccionPerfil;

    public function __construct($operacionAccionPerfil, $catalogoManager, $userSessionManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);
        
        $this->operacionAccionPerfil = $operacionAccionPerfil;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('abm operacionAccionPerfil');

        $arrEntidades = $this->catalogoManager->getArrEntidadJSON('OperacionAccionPerfil');
        
        $view = new ViewModel();

        $view->setVariable('arrOpAccionPerfilJSON', $arrEntidades);

        return $view;
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('abm operacionAccionPerfil - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operacionAccionPerfil->procesarAlta($JsonData);

            $this->redirect()->toRoute("abm/operacionAccionPerfil", ["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('arrVariables', $this->operacionAccionPerfil->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/operacion-accion-perfil/alta.phtml');
        
        return $view;      
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('abm operacionAccionPerfil - editar');
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->operacionAccionPerfil->procesarAlta($JsonData, $idEntidad);

            $this->redirect()->toRoute("abm/operacionAccionPerfil", ["action" => "index"]);
        }

        $Entidad = $this->operacionAccionPerfil->getEntidadPorId($idEntidad);
        $view = new ViewModel();
        
        $view->setVariable('Entidad', $Entidad);
        $view->setVariable('arrVariables', $this->operacionAccionPerfil->getArrVariablesAltaEntidad());
        $view->setTemplate('admin/operacion-accion-perfil/editar.phtml');
        
        return $view;      
    }

    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idEntidad = $parametros['id'];

        $mensaje = $this->operacionAccionPerfil->borrarEntidad($idEntidad);

        return $this->redirect()->toRoute("abm/operacionAccionPerfil", ["action" => "index"]);
    } 
}
