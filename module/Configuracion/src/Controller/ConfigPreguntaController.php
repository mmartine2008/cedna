<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigPreguntaController extends ConfiguracionController
{
    private $configuracionManager;

    public function __construct($catalogoManager, $configuracionManager, $userSessionManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('pregunta');
        
        $arrPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('Preguntas');

        return new ViewModel([
            'arrPreguntasJSON' => $arrPreguntasJSON
        ]);
    }

    public function altaPreguntaAction(){
        $this->cargarAccionesDisponibles('preguntas - alta');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);
            $this->configuracionManager->altaEdicionPreguntas($JsonData);

            $this->redirect()->toRoute("configuracion/preguntas",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $tiposPregunta = $this->catalogoManager->getArrEntidadJSON('TipoPregunta');

        $view->setVariable('tiposPregunta', $tiposPregunta);
        $view->setVariable('PreguntasJson', '""');
        $view->setTemplate('configuracion/config-pregunta/form-preguntas.phtml');
        
        return $view;
    }

    public function editarPreguntaAction(){
        $this->cargarAccionesDisponibles('preguntas - edicion');
        $parametros = $this->params()->fromRoute();

        $idPregunta = $parametros['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionPreguntas($JsonData, $idPregunta);

            $this->redirect()->toRoute("configuracion/preguntas",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Pregunta = $this->catalogoManager->getPreguntas($idPregunta);
        $tiposPregunta = $this->catalogoManager->getArrEntidadJSON('TipoPregunta');

        $view->setVariable('tiposPregunta', $tiposPregunta);
        $view->setVariable('PreguntasJson', $Pregunta->getJSON());
        $view->setTemplate('configuracion/config-pregunta/form-preguntas.phtml');
        
        return $view;
    }
    
    public function borrarPreguntaAction(){
        $preguntas = $this->params()->fromRoute();

        $idPreguntas = $preguntas['id'];

        $mensaje = $this->configuracionManager->borrarPreguntas($idPreguntas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/preguntas",["action" => "index"]);
    } 

}
