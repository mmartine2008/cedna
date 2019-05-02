<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

use Zend\I18n\Translator\Translator;

class ConfiguracionController extends CednaController
{

    public function __construct($catalogoManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);
    }

    public function indexAction()
    {
        // echo($this->translator->translate('Hello', null, 'es_ES'));

        $this->cargarAccionesDisponibles('Configuracion');
        $OperacionesJSON = $this->recuperarOperacionesIniciales('Configuracion');
        return new ViewModel(['OperacionesJSON' => $OperacionesJSON]);
    }
}
