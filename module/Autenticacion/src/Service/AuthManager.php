<?php

/**
 * Este servicio es el responsable de realizar todo lo referido con la
 * autenticacion del sistema.
 * 
 * @author      
 */

namespace Autenticacion\Service;

use Zend\Authentication\Result;
use Empresas\Helper\ParserAfip;

class AuthManager
{
    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    
    /**
     * Session manager.
     * @var Zend\Session\SessionManager
     */
    private $sessionManager;
    
    /**
     * @var array 
     */
    private $config;
 
    /**
     * Service Manager
     * @var type 
     */
    private $afipManager;
    
    /**
     * Constructor del servicio.
     */
    public function __construct($authService, $sessionManager, $config, $afipManager) 
    {
        $this->authService = $authService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
        $this->afipManager = $afipManager;
    }
    
    
    public function login($nombreUsuario, $password, $rememberMe)
    {   
        
        if ($this->authService->getIdentity()!=null) {
            $this->logout();
        }

        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setNombreUsuario($nombreUsuario);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();

        $this->procesarResultadoLogin($result, $rememberMe);
        
        return $result;
    }
    
    private function procesarResultadoLogin($result, $rememberMe)
    {

        if ($result->getCode()==Result::SUCCESS) {

            // // La cookie de sesión caducará en 1 mes (30 días).
            // if ($rememberMe) {
            //     // La cookie de sesión caducará en 1 mes (30 días).
            //     $this->sessionManager->rememberMe(60*60*24*30);
            // }
            
            // $this->registrarPerfil();
        }
    }

    /**
     * Registra el o los perfiles del usaurio
     */
    private function registrarPerfil()
    {
        
        $authStorage = $this->authService->getStorage();
        $authAdapter = $this->authService->getAdapter();
        
        $perfiles = $authAdapter->getPerfiles();
        // Piso lo que habia y registro tanto el usuario como los perfiles
        $authStorage->write([$this->authService->getIdentity(), $perfiles]);
    }
    
    /**
     * Performs user logout.
     */
    public function logout()
    {
        $this->authService->clearIdentity(); 

    }
    
    public function filterAccess($controllerName, $actionName)
    {

        $mode = isset($this->config['options']['mode'])?$this->config['options']['mode']:'restrictive';
        if ($mode!='restrictive' && $mode!='permissive')
            throw new \Exception('Modo de filtro de acceso inválido (se espera el modo restrictivo o permisivo');
        
        if (isset($this->config['controllers'][$controllerName])) {
            $items = $this->config['controllers'][$controllerName];
            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];
                if (is_array($actionList) && in_array($actionName, $actionList) ||
                    $actionList=='*') {
                    if ($allow=='*')
                        return true; 
                    else if ($allow=='@' && $this->authService->hasIdentity()) {
                        return true; 
                    } else {                    
                        return false;
                    }
                }
            }            
        }
        
        if ($mode=='restrictive' && !$this->authService->hasIdentity())
            return false;

        return true;
    }
    
    public function getPerfilInicial()
    {
        $registro = $this->authService->getIdentity();
        // Recupero los perfiles
        $perfiles = $registro[1];
        // Recupera el primer perfil
        $perfilInicial = $perfiles[0];

        return $perfilInicial;
        
    }
    
    /**
     * Dado un CUIT, verifica si es responsable inscripto,
     * recuperando los datos o nulo si no lo es.
     * Pre: Se supone que es un CUIT bien formado
     * @param type $cuit
     */
    public function getDatosResponsableInscripto($cuit)
    {
        $datos = $this->afipManager->getDatosResponsableInscripto($cuit);
        $parserAfip = new ParserAfip($datos);
                
        return $parserAfip;
    }     
    
    public function getDatosEmpresaInscripta($cuit)
    {
        return $this->afipManager->getDatosResponsableInscripto($cuit);

    }   
}