<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigParametrosController extends ConfiguracionController
{
    private $configuracionManager;

    public function __construct($catalogoManager, $configuracionManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('parametros');
        
        $arrParametrosJSON = $this->catalogoManager->getArrEntidadJSON('Parametros');

        return new ViewModel([
            'arrParametrosJSON' => $arrParametrosJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('parametros - alta');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            
            $JsonData = json_decode($data['JsonData']);
            var_dump($JsonData);
            $this->configuracionManager->altaEdicionParametros($JsonData);

            $this->redirect()->toRoute("configuracion/parametros",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('ParametrosJson', '""');
        $view->setTemplate('configuracion/config-parametros/form-parametros.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('parametros - edicion');
        $parametros = $this->params()->fromRoute();

        $idParametros = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionParametros($JsonData, $idParametros);

            $this->redirect()->toRoute("configuracion/parametros",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Parametros = $this->catalogoManager->getParametros($idParametros);

        $view->setVariable('ParametrosJson', $Parametros->getJSON());
        $view->setTemplate('configuracion/config-parametros/form-parametros.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idParametros = $parametros['id'];

        $mensaje = $this->configuracionManager->borrarParametros($idParametros);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/parametros",["action" => "index"]);
    } 

}
