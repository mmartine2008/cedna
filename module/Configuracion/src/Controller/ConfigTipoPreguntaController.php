<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigTipoPreguntaController extends ConfiguracionController
{

    public function __construct($configuracionManager)
    {
        parent::__construct($configuracionManager);
    }

    public function indexAction()
    {
        $arrTipoPreguntas = $this->configuracionManager->getTipoPregunta();

        $arrAccionesDisponibles = $this->configuracionManager->getAccionesPorPerfil('Configuracion Tipo Pregunta', 'Administrador');

        $this->layout()->arrAccionesDisponibles = $arrAccionesDisponibles;

        return new ViewModel([
            'arrTipoPreguntas' => $arrTipoPreguntas
        ]);
    }

}
