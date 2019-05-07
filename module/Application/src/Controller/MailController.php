<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\CednaController;
use Zend\View\Model\ViewModel;

class MailController extends CednaController
{
    private $mailManager;

    public function __construct($catalogoManager, $userSessionManager, $mailManager, $translator, $permisosManager)
    {
        parent::__construct($catalogoManager, $userSessionManager, $translator, $permisosManager);

        $this->mailManager = $mailManager;
    }

    /**
     * Este action sirve para mostrar la pantalla de testeo de envio de mails.
     *
     * @return void
     */
    public function indexAction()
    {
        $this->cargarAccionesDisponibles('mail - index');
        
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            
            $this->mailManager->sendMailPrueba($data);
        }

        $smtp_options = $this->mailManager->getSMTPOptions();

        return new ViewModel([
            'smtp_options' => $smtp_options
        ]);
    }

}
