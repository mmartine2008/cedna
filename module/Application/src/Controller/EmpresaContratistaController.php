<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class EmpresaContratistaController extends CednaController
{
    private $empresasManager;

    public function __construct($catalogoManager, $userSessionManager, $translator, $permisosManager, $empresasManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->empresasManager = $empresasManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('empresas contratistas');
        
        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        $Empresas = $this->catalogoManager->getEmpresasContratistas();
        $arrEmpresasJSON = $this->catalogoManager->arrEntidadesAJSON($Empresas);

        return new ViewModel([
            'arrEmpresasJSON' => $arrEmpresasJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('empresas contratistas - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->empresasManager->altaEdicionEmpresaContratista($JsonData);

            $this->redirect()->toRoute("empresa-contratista",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('EmpresaJson', '""');
        $view->setTemplate('application/empresa-contratista/form-empresas-contratistas.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('empresas contratistas - edicion');
        $parametros = $this->params()->fromRoute();

        $idEmpresaContratista = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->empresasManager->altaEdicionEmpresaContratista($JsonData);

            $this->redirect()->toRoute("empresa-contratista",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $EmpresaContratista = $this->catalogoManager->getEmpresasContratistas($idEmpresaContratista);

        $view->setVariable('EmpresaJson', $EmpresaContratista->getJSON());
        $view->setTemplate('application/empresa-contratista/form-empresas-contratistas.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idEmpresaContratista = $parametros['id'];

        // $mensaje = $this->tareasManager->borrarTareas($idTareas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("empresa-contratista",["action" => "index"]);
    }
}
