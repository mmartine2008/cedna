<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class OrganigramaController extends CednaController
{
    private $organigramaManager;

    public function __construct($catalogoManager, $userSessionManager, $organigramaManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->organigramaManager = $organigramaManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('organigrama');
        
        $OperacionesJSON = $this->recuperarOperacionesIniciales('organigrama');
        
        return new ViewModel(['OperacionesJSON' => $OperacionesJSON]);
    }

    public function nodosAction(){
        $this->cargarAccionesDisponibles('nodos');
        
        $arrNodosJSON = $this->catalogoManager->getArrEntidadJSON('Nodos');

        return new ViewModel([
            'arrNodosJSON' => $arrNodosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('nodos - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->organigramaManager->altaEdicionNodos($JsonData);

            $this->redirect()->toRoute("organigrama/nodos", ["action" => "nodos"]);
        }

        $arrTipoNodo = $this->catalogoManager->getTipoNodo();
        $arrNodos  = $this->catalogoManager->getNodos();

        $view = new ViewModel();
        
        $view->setVariable('arrTipoNodo', $arrTipoNodo);
        $view->setVariable('arrNodos', $arrNodos);
        $view->setTemplate('application/organigrama/alta-nodos.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('nodos - edicion');
        $parametros = $this->params()->fromRoute();

        $idNodos = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->organigramaManager->altaEdicionNodos($JsonData, $idNodos);

            $this->redirect()->toRoute("organigrama/nodos", ["action" => "nodos"]);
        }

        $view = new ViewModel();
        
        $Nodos = $this->catalogoManager->getNodos($idNodos);

        $arrTipoNodo = $this->catalogoManager->getTipoNodo();
        $arrNodos  = $this->catalogoManager->getNodos();

        $view->setVariable('NodosJson', $Nodos->getJSON());
        $view->setVariable('arrTipoNodo', $arrTipoNodo);
        $view->setVariable('arrNodos', $arrNodos);
        $view->setTemplate('application/organigrama/editar-nodos.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idNodos = $parametros['id'];

        $mensaje = $this->organigramaManager->borrarNodos($idNodos);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("organigrama/nodos", ["action" => "nodos"]);
    }
    
    public function AutoridadesAction(){
        $this->cargarAccionesDisponibles('autoridades');
        
        $arrNodosJSON = $this->catalogoManager->getArrEntidadJSON('Nodos');

        $view = new ViewModel();
        $view->setVariable('arrNodosJSON', $arrNodosJSON);
        
        return $view;
    }

    public function editarAutoridadesAction(){
        $this->cargarAccionesDisponibles('autoridades - edicion');
        
        $parametros = $this->params()->fromRoute();
        $idNodos = $parametros['id'];
        $Nodos = $this->catalogoManager->getNodos($idNodos);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->organigramaManager->altaEdicionAutoridades($JsonData, $Nodos);

            $this->redirect()->toRoute("organigrama/autoridades", ["action" => "autoridades"]);
        }

        $arrUsuariosJSON  = $this->organigramaManager->getUsuariosDisponiblesParaJefe($Nodos);
        $arrTipoJefeJSON  = $this->catalogoManager->getArrEntidadJSON('TipoJefe');
        $arrEsJefeDeJSON = $this->organigramaManager->getArrJefesInicialesJSON($Nodos);

        $view = new ViewModel();
        
        $view->setVariable('NodosJson', $Nodos->getJSON());
        $view->setVariable('arrUsuariosJSON', $arrUsuariosJSON);
        $view->setVariable('arrTipoJefeJSON', $arrTipoJefeJSON);
        $view->setVariable('arrEsJefeDeJSON', $arrEsJefeDeJSON);
        $view->setTemplate('application/organigrama/form-autoridades.phtml');
        
        return $view;
    }

    public function dibujarAction(){
        $this->cargarAccionesDisponibles('organigrama - dibujar');

        $nodoRaiz = $this->organigramaManager->getNodoRaiz();

        $view = new ViewModel();
        
        $view->setVariable('nodoRaiz', $nodoRaiz->getJSONOrganigrama());
        $view->setTemplate('application/organigrama/dibujo-organigrama.phtml');
        
        return $view;
    }

}
