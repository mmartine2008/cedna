<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class ABMController extends CednaController
{
    private $accionManager;
    private $operacionManager;
    private $operacionAccionPerfilManager;

    public function __construct($accionManager, $operacionManager, $operacionAccionPerfilManager, 
                                $catalogoManager, $userSessionManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->accionManager = $accionManager;
        $this->operacionManager = $operacionManager;
        $this->operacionAccionPerfilManager = $operacionAccionPerfilManager;
    }

    /**
     * Esta funcion lista todas las posibles configuraciones internas del sistema
     *
     * @return void
     */
    public function indexAction()
    {
        $this->cargarAccionesDisponibles('abms');
        return new ViewModel();
    }

    
}
