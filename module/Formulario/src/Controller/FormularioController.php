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

    public function __construct($FormularioManager) {
        $this->FormularioManager = $FormularioManager;
    }

    public function indexAction() {
        $idFormulario = 1;
        $formularioJSON = $this->FormularioManager->getFormularioJSON($idFormulario);

        return new ViewModel([
            "formulario" => $formularioJSON
        ]);
    }

    public function showFormAction() {
        $idFormulario = 1;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $JsonData = $this->params()->fromPost();
            $data = json_decode($JsonData['JsonData']);
            var_dump($data);
            $this->FormularioManager->altaRespuestasFormulario($data->datos);
        }
        // $respuestasJson = $this->FormularioManager->getRespuestasFormularioJSON($idFormulario);
        // var_dump($respuestasJson);
        return new ViewModel([
            // "respuestas" => $respuestasJson
        ]);
    }

}
