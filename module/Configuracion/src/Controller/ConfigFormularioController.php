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

    public function __construct($catalogoManager, $configuracionManager, $userSessionManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('formulario');
        
        $arrSeccionesJSON = $this->catalogoManager->getArrEntidadJSON('Secciones');

        return new ViewModel([
            'arrSeccionesJSON' => $arrSeccionesJSON
        ]);
    }

    public function altaSeccionAction(){
        $this->cargarAccionesDisponibles('secciones - alta');

        $parametros = $this->params()->fromRoute();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);
            var_dump($JsonData);
            $this->configuracionManager->altaSecciones($JsonData);

            $this->redirect()->toRoute("configuracion/secciones");
        }

        $view = new ViewModel();

        $arrPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('Preguntas');
        
        $view->setVariable('estados', "");
        $view->setVariable('SeccionJson', '""');
        $view->setVariable('arrPreguntasJson', $arrPreguntasJSON);
        $view->setTemplate('configuracion/config-formulario/form-secciones.phtml');
        
        return $view;
    }

    public function editarSeccionAction(){
        $this->cargarAccionesDisponibles('secciones - edicion');
        $secciones = $this->params()->fromRoute();

        $idSeccion = $secciones['id'];

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $JsonData = json_decode($data['JsonData']);
            $preguntasEnlazadas = json_decode($data['seleccionados']);
            $preguntasRequeridas = json_decode($data['required']);

            $this->configuracionManager->edicionSecciones($JsonData, $idSeccion, $preguntasEnlazadas, $preguntasRequeridas);

            $this->redirect()->toRoute("configuracion/secciones");
        }

        $view = new ViewModel();
        
        $Secciones = $this->catalogoManager->getSecciones($idSeccion);
        $arrPreguntasJSON = $this->catalogoManager->getArrEntidadJSON('Preguntas');
        $estados = $this->configuracionManager->getEstadoPreguntasSeccion($idSeccion);
        $arrayRequired = $this->configuracionManager->getEstadoRequiredPreguntasSeccion($idSeccion);


        $view->setVariable('estados', $estados);
        $view->setVariable('arrayRequired', $arrayRequired);
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
        return $this->redirect()->toRoute("configuracion/secciones");
    } 

    public function clonarSeccionAction(){
        $secciones = $this->params()->fromRoute();

        $idSecciones = $secciones['id'];

        $mensaje = $this->configuracionManager->clonarSeccion($idSecciones);

        //Todavia no hay para mostrar mensajes
        return $this->redirect()->toRoute("configuracion/secciones");
    } 

}
