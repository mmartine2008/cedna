<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CednaController extends AbstractActionController
{
    protected $catalogoManager;
    protected $userSessionManager;

    public function __construct($catalogoManager, $userSessionManager)
    {
        $this->catalogoManager = $catalogoManager;
        $this->userSessionManager = $userSessionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('index');
        
        $OperacionesJSON = $this->recuperarOperacionesIniciales('index');
        
        return new ViewModel(['OperacionesJSON' => $OperacionesJSON]);
    }

    protected function cargarAccionesDisponibles($nombreOperacion){
        $PerfilActivo = $this->userSessionManager->getPerfilActivo();

        $arrAccionesDisponibles = $this->catalogoManager->getAccionesPorPerfil($nombreOperacion, $PerfilActivo);

        $arrAccionesDisponiblesJSON = [];

        foreach($arrAccionesDisponibles as $AccionDisponible){
            $arrAccionesDisponiblesJSON[] = $AccionDisponible->getJSON();
        }

        $arrAccionesDisponiblesJSON = implode(", ", $arrAccionesDisponiblesJSON);

        $this->layout()->arrAccionesDisponibles = '[' . $arrAccionesDisponiblesJSON . ']';
    }

    protected function recuperarOperacionesIniciales($nombreOperacion){
        $PerfilActivo = $this->userSessionManager->getPerfilActivo();

        $arrOperacionesDisponibles = $this->catalogoManager->getOperacionesInicialesPorPerfil($PerfilActivo, $nombreOperacion);

        $arrOperacionesDisponiblesJSON = [];

        foreach($arrOperacionesDisponibles as $OperacionJSON){
            $arrOperacionesDisponiblesJSON[] = $OperacionJSON->getJSON();
        }

        $arrOperacionesDisponiblesJSON = implode(", ", $arrOperacionesDisponiblesJSON);

        return '[' . $arrOperacionesDisponiblesJSON . ']';
    }
}
