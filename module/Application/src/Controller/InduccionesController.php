<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class InduccionesController extends CednaController
{
    private $induccionesManager;

    public function __construct($catalogoManager, $userSessionManager, $induccionesManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->induccionesManager = $induccionesManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('inducciones');
        
        $arrInduccionesJSON = $this->catalogoManager->getArrEntidadJSON('Inducciones');

        return new ViewModel([
            'arrInduccionesJSON' => $arrInduccionesJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('inducciones - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->induccionesManager->altaEdicionInducciones($JsonData);

            $this->redirect()->toRoute("inducciones", ["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('InduccionesJson', '""');
        $view->setTemplate('application/inducciones/alta-inducciones.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('inducciones - edicion');
        $parametros = $this->params()->fromRoute();

        $idInducciones = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->induccionesManager->altaEdicionInducciones($JsonData, $idInducciones);

            $this->redirect()->toRoute("inducciones",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Inducciones = $this->catalogoManager->getInducciones($idInducciones);

        $view->setVariable('InduccionesJson', $Inducciones->getJSON());
        $view->setTemplate('application/inducciones/editar-inducciones.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idInducciones = $parametros['id'];

        $mensaje = $this->induccionesManager->borrarOperarios($idInducciones);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("inducciones",["action" => "index"]);
    } 

}
