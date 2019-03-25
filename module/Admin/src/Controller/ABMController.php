<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ABMController extends AbstractActionController
{
    private $accionManager;
    private $operacionManager;
    private $operacionAccionPerfilManager;

    public function __construct($accionManager, $operacionManager, $operacionAccionPerfilManager)
    {
        $this->accionManager = $accionManager;
        $this->operacionManager = $operacionManager;
        $this->operacionAccionPerfilManager = $operacionAccionPerfilManager;

        $this->layout()->arrAccionesDisponibles = null;
    }

    /**
     * Esta funcion lista todas las posibles configuraciones internas del sistema
     *
     * @return void
     */
    public function indexAction()
    {

        return new ViewModel();
    }

    
}
