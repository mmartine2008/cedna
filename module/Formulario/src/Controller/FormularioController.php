<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FormularioController extends AbstractActionController
{
    private $FormularioManager;

    public function __construct($FormularioManager)
    {
        $this->FormularioManager = $FormularioManager;
        
    }

    public function indexAction()
    {
        $formularioJSON = $this->FormularioManager->getFormularioJSON(1);
        return new ViewModel([
            "formulario" => $formularioJSON
        ]);
    }

}
