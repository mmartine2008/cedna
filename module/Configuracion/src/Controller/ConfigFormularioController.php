<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigFormularioController extends ConfiguracionController
{
    private $configuracionManager;

    public function __construct($catalogoManager, $configuracionManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('formulario');
        
        $arrFormulariosJSON = $this->catalogoManager->getArrEntidadJSON('Formulario');

        return new ViewModel([
            'arrFormulariosJSON' => $arrFormulariosJSON
        ]);
    }

    public function altaFormularioAction(){
        $this->cargarAccionesDisponibles('formularios - alta');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);
            $this->configuracionManager->altaEdicionFormularios($JsonData);

            $this->redirect()->toRoute("configuracion/formularios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('FormulariosJson', '""');
        $view->setTemplate('configuracion/config-formulario/form-formularios.phtml');
        
        return $view;
    }

    public function editarFormularioAction(){
        $this->cargarAccionesDisponibles('formularios - edicion');
        $formularios = $this->params()->fromRoute();

        $idFormularios = $formularios['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionFormularios($JsonData, $idFormularios);

            $this->redirect()->toRoute("configuracion/formularios",["action" => "index"]);
        }

        $view = new ViewModel();
        
        $Formularios = $this->catalogoManager->getFormularios($idFormularios);

        $view->setVariable('FormulariosJson', $Formularios->getJSON());
        $view->setTemplate('configuracion/config-formulario/form-formularios.phtml');
        
        return $view;
    }
    
    public function borrarFormularioAction(){
        $formularios = $this->params()->fromRoute();

        $idFormularios = $formularios['id'];

        $mensaje = $this->configuracionManager->borrarFormularios($idFormularios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios",["action" => "index"]);
    } 

    public function clonarFormularioAction(){
        $formularios = $this->params()->fromRoute();

        $idFormularios = $formularios['id'];

        $mensaje = $this->configuracionManager->clonarFormularios($idFormularios);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios",["action" => "index"]);
    } 

    public function altaSeccionAction(){
        $this->cargarAccionesDisponibles('secciones - alta');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);
            var_dump($JsonData);
            $this->configuracionManager->altaEdicionSecciones($JsonData);

            $this->redirect()->toRoute("configuracion/formularios",["action" => "editarFormulario"]);
        }

        $view = new ViewModel();

        $arrPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('Preguntas');
        
        $view->setVariable('SeccionJson', '""');
        $view->setVariable('arrPreguntasJson', $arrPreguntasJSON);
        $view->setTemplate('configuracion/config-formulario/form-secciones.phtml');
        
        return $view;
    }

    public function editarSeccionAction(){
        $this->cargarAccionesDisponibles('secciones - edicion');
        $secciones = $this->params()->fromRoute();

        $idSecciones = $secciones['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionSecciones($JsonData, $idSecciones);

            $this->redirect()->toRoute("configuracion/formularios",["action" => "editarFormulario"]);
        }

        $view = new ViewModel();
        
        $Secciones = $this->catalogoManager->getSecciones($idSecciones);
        $arrPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('Preguntas');

        $view->setVariable('SeccionJson', $Secciones->getJSON());
        $view->setVariable('arrPreguntasJson', $arrPreguntasJSON);
        
        $view->setTemplate('configuracion/config-formulario/form-secciones.phtml');
        
        return $view;
    }
    
    public function borrarSeccionAction(){
        $secciones = $this->params()->fromRoute();

        $idSecciones = $secciones['id'];

        $mensaje = $this->configuracionManager->borrarSecciones($idSecciones);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios",["action" => "editarFormulario"]);
    } 

    public function clonarSeccionAction(){
        $secciones = $this->params()->fromRoute();

        $idSecciones = $secciones['id'];

        $mensaje = $this->configuracionManager->clonaridSecciones($idSecciones);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios",["action" => "editarFormulario"]);
    } 

    public function altaPreguntaAction(){
        $this->cargarAccionesDisponibles('preguntas - alta');
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);
            var_dump($JsonData);
            $this->configuracionManager->altaEdicionPreguntas($JsonData);

            $this->redirect()->toRoute("configuracion/formularios/secciones",["action" => "editarSecciones"]);
        }

        $view = new ViewModel();
        
        $view->setVariable('FormulariosJson', '""');
        $view->setTemplate('configuracion/config-formulario/form-preguntas.phtml');
        
        return $view;
    }

    public function editarPreguntaAction(){
        $this->cargarAccionesDisponibles('preguntas - edicion');
        $preguntas = $this->params()->fromRoute();

        $idPreguntas = $preguntas['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->altaEdicionPreguntas($JsonData, $idPreguntas);

            $this->redirect()->toRoute("configuracion/formularios/secciones",["action" => "editarSecciones"]);
        }

        $view = new ViewModel();
        
        $Preguntas = $this->catalogoManager->getPreguntas($idPreguntas);

        $view->setVariable('PreguntasJson', $Preguntas->getJSON());
        $view->setTemplate('configuracion/config-formulario/form-preguntas.phtml');
        
        return $view;
    }
    
    public function borrarPreguntaAction(){
        $formularios = $this->params()->fromRoute();

        $idPreguntas = $formularios['id'];

        $mensaje = $this->configuracionManager->borrarPreguntas($idPreguntas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios/secciones",["action" => "editarSecciones"]);
    } 

    public function enlazarPreguntaAction(){
        $preguntas = $this->params()->fromRoute();

        $idPreguntas = $preguntas['id'];

        $mensaje = $this->configuracionManager->enlazarPreguntas($idPreguntas);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/formularios/secciones",["action" => "editarSecciones"]);
    } 
}
