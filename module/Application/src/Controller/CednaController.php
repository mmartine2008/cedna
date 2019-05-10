<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;

class CednaController extends AbstractActionController
{
    protected $catalogoManager;
    protected $userSessionManager;
    protected $translator;
    protected $permisosManager;

    public function __construct($catalogoManager, $userSessionManager, $translator, $permisosManager)
    {
        $this->translator = $translator;
        $this->catalogoManager = $catalogoManager;
        $this->userSessionManager = $userSessionManager;
        $this->permisosManager = $permisosManager;

    }

    public function indexAction()
    {
        $this->cargarAccionesDisponibles('index');
        
        $OperacionesJSON = $this->recuperarOperacionesIniciales('index');
        
        return new ViewModel(['OperacionesJSON' => $OperacionesJSON]);
    }

    protected function cargarAccionesDisponibles($nombreOperacion){
        $PerfilActivo = $this->userSessionManager->getPerfilActivo();

        $arrAccionesDisponibles = $this->catalogoManager->getAccionesPorPerfil($nombreOperacion, $PerfilActivo);
        $arrAccionesDisponiblesJSON = [];

        foreach($arrAccionesDisponibles as $AccionDisponible){
            $arrAccionesDisponiblesJSON[] = $AccionDisponible->getJSON();
        }

        $arrAccionesDisponiblesJSON = implode(", ", $arrAccionesDisponiblesJSON);

        $this->layout()->arrAccionesDisponibles = '[' . $arrAccionesDisponiblesJSON . ']';

        $this->cargarNombrePerfilConectado($PerfilActivo);
    }

    protected function recuperarOperacionesIniciales($nombreOperacion){
        $PerfilActivo = $this->userSessionManager->getPerfilActivo();

        $arrOperacionesDisponibles = $this->catalogoManager->getOperacionesInicialesPorPerfil($PerfilActivo, $nombreOperacion);

        $arrOperacionesDisponiblesJSON = [];

        foreach($arrOperacionesDisponibles as $OperacionJSON){
            $arrOperacionesDisponiblesJSON[] = $OperacionJSON->getJSON();
        }

        $arrOperacionesDisponiblesJSON = implode(", ", $arrOperacionesDisponiblesJSON);

        return '[' . $arrOperacionesDisponiblesJSON . ']';
    }

    private function cargarNombrePerfilConectado($PerfilActivo){
        $userName = $this->userSessionManager->getUserName();
        $UsuarioActivo = $this->catalogoManager->getUsuarioPorNombreUsuario($userName);

        $this->layout()->nombreApellidoUsuario = $UsuarioActivo->getNombre() .', '. $UsuarioActivo->getApellido();
        $this->layout()->perfilUsuario = $PerfilActivo->getNombre();
    }

        /**
     * Validaciones que se hacen cuando el usuario no esta logueado
     */
    protected function validarOnNotLoggin($controller, $action, $method)
    {

        if (($controller == 'Autenticacion\Controller\AuthController') && 
                ($action == 'resetPassword'))
        {
            return true;
        } 
        
        if (!$this->permisosManager->validarLogin($controller, $action, $method))
        {
            return false;
        } else
        {
            return true;
        }    
    }
    
    /**
     * En adelante se utilizara ACL
     * @param type $controller
     * @param type $action
     * @param type $method
     * @return boolean
     */
    protected function validarPermisos($controller, $action, $method)
    {
        // Si no esta logueado puede acceder al login
        if (!$this->isLogged()) {
            return $this->validarOnNotLoggin($controller, $action, $method);
        }

        $perfil = $this->userSessionManager->getPerfilActivo()->getNombre();
        $valido = $this->permisosManager->verificar($perfil, $controller, $method);

        if (!$valido)
        {
            $this->userSessionManager->addMessage('Acceso no permitido');
        }
        
        return $valido;
    }

    protected function isLogged() {
        return $this->userSessionManager->isLogged();
    }

     /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws Exception\DomainException
     */
    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new Exception\DomainException('Ruta equivocada:');
        }
        
        
        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);
        $controller = $routeMatch->getParam('controller', 'not-found');

        if (($action == 'logout') || 
         (!$this->validarPermisos($controller, $action, $method)))
        {
            $this->redirect()->toRoute('login');            
        }
       
        return parent::onDispatch($e);
    }  

    
     
}
