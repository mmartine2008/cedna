<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion\Controller;

use Zend\View\Model\ViewModel;
use Configuracion\Controller\ConfiguracionController;

class ConfigNotifXPerfilController extends ConfiguracionController
{

    private $configuracionManager;

    public function __construct($catalogoManager, $configuracionManager, $userSessionManager, $translator)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator);

        $this->configuracionManager = $configuracionManager;
    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('configuracion - notificaciones x perfil');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $JsonData = json_decode($data['JsonData']);

            $this->configuracionManager->guardarNotificacionesXPerfiles($JsonData);

            $this->redirect()->toRoute("configuracion",["action" => "index"]);
        }

        $arrNotificacionesXPerfilJSON = $this->catalogoManager->getArrEntidadJSON('NotificacionesXPerfil');
        $arrPerfilesJSON = $this->catalogoManager->getArrEntidadJSON('Perfiles');
        $arrTiposEventoJSON = $this->catalogoManager->getArrEntidadJSON('TiposEvento');

        return new ViewModel([
            'arrNotificacionesXPerfilJSON' => $arrNotificacionesXPerfilJSON,
            'arrPerfilesJSON' => $arrPerfilesJSON,
            'arrTiposEventoJSON' => $arrTiposEventoJSON
        ]);
    }

    

}
