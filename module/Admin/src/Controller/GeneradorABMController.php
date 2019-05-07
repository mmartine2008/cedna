<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class GeneradorABMController extends CednaController
{
    private $generadorABMManager;

    public function __construct($catalogoManager, $userSessionManager, $translator, $generadorABMManager, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);
        
        $this->generadorABMManager = $generadorABMManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('generador ABM');

        //Recuperar todas las entidades del sistema..
        //Recuperar el listado de modulos..
        
        $view = new ViewModel();

        //$view->setVariable('arrAccionesJSON', $arrEntidades);

        return $view;
    }

    
}
