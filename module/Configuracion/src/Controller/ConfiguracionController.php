<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConfiguracionController extends AbstractActionController
{
    protected $catalogoManager;

    public function __construct($catalogoManager)
    {
        $this->catalogoManager = $catalogoManager;
        
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('Configuracion', 'Administrador');
        return new ViewModel();
    }

    protected function cargarAccionesDisponibles($nombreOperacion, $nombrePerfil){
        $arrAccionesDisponibles = $this->catalogoManager->getAccionesPorPerfil($nombreOperacion, $nombrePerfil);

        $this->layout()->arrAccionesDisponibles = $arrAccionesDisponibles;
    }

}
