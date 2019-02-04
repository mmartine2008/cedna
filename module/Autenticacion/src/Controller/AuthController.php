<?php

/**
 *Este controlador gestiona la interacción del usuario con el sistema
 *para acceder a las funcionalidades referentes a la autenticacion.
 * 
 * @author      
 */

namespace Autenticacion\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;

use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class AuthController extends AbstractActionController
{
    
    /**
     * Auth manager.
     * @var User\Service\AuthManager
     */
    private $authManager;

    /**
     * User manager.
     * @var User\Service\UserManager
     */
    private $userManager;

    /**
     * Constructor.
     */
    public function __construct($permisosManager, $authManager, $userManager, 
                                        $userSessionManager, $empresasManager)
    {
        // parent::__construct($permisosManager, $userSessionManager);
        
        $this->empresasManager = $empresasManager;
        $this->authManager = $authManager;
        $this->userManager = $userManager;
    }
    
    private function procesarLoginAction()
    {
        // Fill in the form with POST data
        $data = $this->params()->fromPost();

        // TODO: Validar los datos ingresados
        $recordar = (array_key_exists('Recordar', $data) && ($data['Recordar'] == 'on'));

        $result = $this->authManager->login('admin', '1234', true);

        // $result = $this->authManager->login(
        //     $data['Usuario'], $data['Clave'], $recordar);
        
        // Check result.
        if ($result->getCode() == Result::SUCCESS) {
            
            return $this->redirigirSegunPerfil();
        } else {
            $mensajes = $result->getMessages();
            $this->userSessionManager->addMessage($mensajes[0]);
        }
        
    }

    /**
     * Segun el primero de los roles que tiene definido
     * redirige a la URL. Luego se chequea la validez nuevamente
     * para evitar ingreso directo
     * @return type
     */
    private function redirigirSegunPerfil()
    {
        
        // $Perfil = $this->authManager->getPerfilInicial();
        
        // $urlDefault = $Perfil->getDefaultHome();

        return $this->redirect()->toRoute('abm');
    }
    
    /**
     * Authenticates user given email address and password credentials.
     */
    public function loginAction()
    {
        $this->layout()->setTemplate('layout/login');
        
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            $this->procesarLoginAction();
        }

        // Tiene que cargar los mensajes que tenga pendientes, porque puede venir de un rechazo
        // $this->cargarMensajes(); 
        $view = new ViewModel();
        
        return $view;
    }

    /**
     * The "logout" action performs logout operation.
     */
    public function logoutAction()
    {
        $this->authManager->logout();
        $this->userSessionManager->cerrar();
        
        return $this->redirect()->toRoute('login');
    }

    private function procesarRegistro()
    {   
        $this->layout()->setTemplate('layout/registro');
        $request = $this->getRequest();

       if ($request->isPost()) {
            $data = $this->params()->fromPost();

            if (!$this->userManager->getUser($data['Usuario']))
            {
                $this->userSessionManager->setClave($data['Clave']);
                $this->userSessionManager->setEmail($data['email']);
                $this->userSessionManager->setUserName($data['Usuario']);
                $this->redirect()->toRoute('alta-empresa');
            }
        }

        $view = new ViewModel();
        
        return  $view;        
        
    }
    
    public function registroAction() {
        
        $view = $this->procesarRegistro();
        
        return  $view;        
    }
 
   /**
     * Accion que se dispara por Ajax, desde el login para reiniciar la clave
     */
    public function resetPasswordAction()
    {
        $this->validateAjaxRequest();

        $params = $this->params()->fromRoute();

        $nombreUsuario = $params['userPass'];
        
        if (strpos($nombreUsuario, '_'))
        { //Entonces es un nombreUsuario de establecimiento modificado
            $nombreUsuario = str_replace('_', '/', $nombreUsuario);
        }
       
        $mensaje = $this->userManager->resetPassword($nombreUsuario);

        return $this->getJsonResponse(['mensaje' => $mensaje]);    
    }


    public function sendmailAction() {
        $request = $this->getRequest();

        $mensaje = "";
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $mensaje = $this->userManager->sendMailPrueba($data);
        }
        
        $smpt_options = $this->userManager->getSMTPOptions();
                
        $view = new ViewModel(
                [   
                    'smtp_options' => $smpt_options,
                    'mensaje' => $mensaje]
                            );
        $view->setTemplate('usuarios/auth/sendmail.phtml');
        
        return  $view;        
    }
    
    public function cambiarPerfilActivoAction()
    {
        
        $this->validateAjaxRequest();
        
        $params = $this->params()->fromRoute();
//         Verifica que sea un requerimiento via Javascript:
        
        $nombrePerfil = $params['id'];
        
        $i = 0;
        foreach ($this->userSessionManager->getPerfiles() as $perfil)
        {
            if ($nombrePerfil == $perfil->getNombre())
            {
                $this->userSessionManager->setPerfilActivo($i);
                break;
            }
            $i ++;
        }
        
        $view = new ViewModel();

        return  $view; 
        
    }

    public function indexAction()
    {
        
        // if (! $this->isLogged() )
        // {
        //     $this->redirect()->toRoute('login');
        // }        
        
        // $this->procesarIngresoUsuario();
    }    
    
    /**
     * A este punto se puede llegar desde distintos lugares
     * @throws \Exception
     */
    public function procesarIngresoUsuario()
    {
        // Ahora en la sesion vienen los perfiles del usuario
        $this->userSessionManager->setPerfilActivo(0);
        
        if ($this->esInterno())
        {
            $this->redirect()->toRoute('gestion');
        } else {
            $this->redirect()->toRoute('empresas');
        }
        
    }

   
}
