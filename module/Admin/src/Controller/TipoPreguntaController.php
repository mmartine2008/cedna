<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\CednaController;

class TipoPreguntaController extends CednaController
{

    private $tipoPreguntaManager;

    public function __construct($catalogoManager, $tipoPreguntaManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->tipoPreguntaManager = $tipoPreguntaManager;
    }

    public function indexAction()
    {
        
        $this->cargarAccionesDisponibles('tipo pregunta');

        $arrTipoPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('TipoPregunta');
        
        return new ViewModel([
            'arrTipoPreguntasJSON' => $arrTipoPreguntasJSON
        ]);
    }

    public function altaAction(){
        $this->cargarAccionesDisponibles('tipo pregunta - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->tipoPreguntaManager->altaEdicionTipoPregunta($JsonData);

            $this->redirect()->toRoute("abm/tipo-pregunta",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('TipoPreguntaJson', '""');
        $view->setTemplate('admin/tipo-pregunta/alta.phtml');
        
        return $view;
    }

    public function editarAction(){
        $this->cargarAccionesDisponibles('tipo pregunta - edicion');

        $parametros = $this->params()->fromRoute();

        $idTipoPregunta = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->tipoPreguntaManager->altaEdicionTipoPregunta($JsonData, $idTipoPregunta);

            $this->redirect()->toRoute("abm/tipo-pregunta",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $TipoPregunta = $this->catalogoManager->getTipoPregunta($idTipoPregunta);

        $view->setVariable('TipoPreguntaJson', $TipoPregunta->getJSON());
        $view->setTemplate('admin/tipo-pregunta/editar.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idTipoPregunta = $parametros['id'];

        $mensaje = $this->tipoPreguntaManager->borrarTipoPregunta($idTipoPregunta);

        return $this->redirect()->toRoute("abm/tipo-pregunta",["action" => "index"]);
    } 

}
