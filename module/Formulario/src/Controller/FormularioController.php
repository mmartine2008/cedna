<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class FormularioController extends CednaController
{
    private $FormularioManager;

    public function __construct($FormularioManager, $catalogoManager, $userSessionManager) {
        parent::__construct($catalogoManager, $userSessionManager);

        $this->FormularioManager = $FormularioManager;
    }

    public function indexAction() {
        $this->cargarAccionesDisponibles('Formulario');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('Formulario');
        $idFormulario = 2;
        $formularioJSON = $this->FormularioManager->getFormularioJSON($idFormulario);
        
        return new ViewModel([
            "formulario" => $formularioJSON,
            "OperacionesJSON" => $OperacionesJSON,
        ]);
    }

    public function showFormAction() {
        $idFormulario = 1;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $JsonData = $this->params()->fromPost();
            $data = json_decode($JsonData['JsonData']);
            $this->FormularioManager->altaRespuestasFormulario($data);
        }
        return new ViewModel([
        ]);
    }

}
