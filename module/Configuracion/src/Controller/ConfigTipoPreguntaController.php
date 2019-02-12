<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigTipoPreguntaController extends ConfiguracionController
{

    private $configuracionManager;

    public function __construct($catalogoManager, $configuracionManager)
    {
        parent::__construct($catalogoManager);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $arrTipoPreguntas = $this->catalogoManager->getTipoPregunta();

        $arrAccionesDisponibles = $this->catalogoManager->getAccionesPorPerfil('Configuracion Tipo Pregunta', 'Administrador');

        $this->layout()->arrAccionesDisponibles = $arrAccionesDisponibles;

        return new ViewModel([
            'arrTipoPreguntas' => $arrTipoPreguntas
        ]);
    }

    public function altaAction(){
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionTipoPregunta($JsonData);

            $this->redirect()->toRoute("configuracion/tipo-pregunta",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('TipoPreguntaJson', '""');
        $view->setTemplate('configuracion/config-tipo-pregunta/form-tipo-pregunta.phtml');
        
        return $view;
    }

    public function editarAction(){
        $parametros = $this->params()->fromRoute();

        $idTipoPregunta = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionTipoPregunta($JsonData, $idTipoPregunta);

            $this->redirect()->toRoute("configuracion/tipo-pregunta",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $TipoPregunta = $this->catalogoManager->getTipoPregunta($idTipoPregunta);

        $view->setVariable('TipoPreguntaJson', $TipoPregunta->getJSON());
        $view->setTemplate('configuracion/config-tipo-pregunta/form-tipo-pregunta.phtml');
        
        return $view;
    }
    
    public function borrarAction(){
        $parametros = $this->params()->fromRoute();

        $idTipoPregunta = $parametros['id'];

        $mensaje = $this->configuracionManager->borrarTipoPregunta($idTipoPregunta);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/tipo-pregunta",["action" => "index"]);
    } 

}
