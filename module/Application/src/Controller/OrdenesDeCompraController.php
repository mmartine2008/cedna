<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OrdenesDeCompraController extends CednaController
{
    private $ordenesDeCompraManager;

    public function __construct($catalogoManager, $userSessionManager, $ordenesDeCompraManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->ordenesDeCompraManager = $ordenesDeCompraManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('ordenes de compra');
        
        $arrOrdenesDeCompraJSON = $this->catalogoManager->getArrOrdenesDeCompraJSON();

        return new ViewModel([
            'arrOrdenesDeCompraJSON' => $arrOrdenesDeCompraJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('ordenes de compra - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $userName = $this->userSessionManager->getUserName();
            $this->ordenesDeCompraManager->altaEdicionOrdenesDeCompra($JsonData, $userName);

            $this->redirect()->toRoute("ordenes-de-compra",["action" => "index"]);
        }
        
        $arrNodosJSON = $this->catalogoManager->getArrNodosJSON();
        $arrUsuariosJSON = $this->catalogoManager->getArrUsuariosJSON();

        $view = new ViewModel();
        
        $view->setVariable('OrdenesDeCompraJson', '""');
        $view->setVariable('arrNodosJSON', $arrNodosJSON);
        $view->setVariable('arrUsuariosJSON', $arrUsuariosJSON);
        $view->setTemplate('application/ordenes-de-compra/form-ordenes-de-compra.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('ordenes de compra - edicion');
        $parametros = $this->params()->fromRoute();

        $idOrdenesDeCompra = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $userName = $this->userSessionManager->getUserName();
            $this->ordenesDeCompraManager->altaEdicionOrdenesDeCompra($JsonData, $userName, $idOrdenesDeCompra);

            $this->redirect()->toRoute("ordenes-de-compra",["action" => "index"]);
        }

        $arrNodosJSON = $this->catalogoManager->getArrNodosJSON();
        $arrFormularioJSON = $this->catalogoManager->getArrFormularioJSON();

        $view = new ViewModel();
        
        $OrdenesDeCompra = $this->catalogoManager->getOrdenesDeCompra($idOrdenesDeCompra);

        $view->setVariable('OrdenesDeCompraJson', $OrdenesDeCompra->getJSON());
        $view->setVariable('arrNodosJSON', $arrNodosJSON);
        $view->setVariable('arrFormularioJSON', $arrFormularioJSON);
        $view->setTemplate('application/ordenes-de-compra/form-ordenes-de-compra.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idOrdenesDeCompra = $parametros['id'];

        $mensaje = $this->ordenesDeCompraManager->borrarOrdenesDeCompra($idOrdenesDeCompra);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("ordenes-de-compra",["action" => "index"]);
    } 

}
