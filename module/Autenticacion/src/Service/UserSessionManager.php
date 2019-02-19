<?php

/**
 * Este servicio es un Wrapper de la Session
 * Centraliza los pedidos de nombre de usaurio, perfiles, perfil activo,
 * tarea activa, etc.
 * 
 * @author      Mariano Martinez
 */

namespace Autenticacion\Service;

class UserSessionManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $sessionContainer; 
    
    /**
     * Constructor del Servicio
     */
    public function __construct($sessionContainer) 
    {
        $this->sessionContainer = $sessionContainer;
    }
 
    /**
     * Manejo de mensaje
     * @param type $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->sessionContainer->mensaje = $mensaje;
    }

    public function addMessage($mensaje)
    {
        if ($this->isSetMensaje()) {
            $this->sessionContainer->mensaje .= '</p>'. $mensaje;
        } else
        {
            $this->setMensaje($mensaje);
        }
    }
    
    public function getMensaje()
    {
        return $this->sessionContainer->mensaje;
    }

    public function isSetMensaje()
    {
        return isset($this->sessionContainer->mensaje);
    }

    public function unsetMensaje()
    {
        unset($this->sessionContainer->mensaje);
    }

    /**
     * Gestion de userName
     * @return type
     */
    public function getUserName()
    {
        $dataSession = $this->sessionContainer->session;
        $userName = $dataSession[0];
        
        return $userName;
    }
 
    /**
     * Para compatibilidad con el servicio de autorizacion
     * registra un para [nombre, perfiles]
     * @return type
     */
    public function setUserName($userName)
    {
        $dataSession = [$userName];
        $this->sessionContainer->session = $dataSession;
    }
    
    public function isSetUserName()
    {
        return isset($this->sessionContainer->session);
    }
    
    /**
     * Gestion de perfiles
     * La session guarda en el 0 el cuit o nombre de usaurio y en 1 el arreglo de perfiles
     * Sucede que en el alta de empresa no hay 1, por eso lo controlo
     * @return type
     */
    public function getPerfiles()
    {
        $dataSession = $this->sessionContainer->session;
        var_dump($dataSession);
        die;
        if (isset($dataSession[1]))
        {
            $perfiles = $dataSession[1];
            return $perfiles;
        }
        return null;
    }

    public function isLogged()
    {
        return isset($this->sessionContainer->perfilActivo);
    }
    /**
     * Recupera una instancia de Perfil de la Session
     * @return type
     */
    public function getPerfilActivo()
    {
        if (!isset($this->sessionContainer->perfilActivo)) 
        {
            $this->sessionContainer->perfilActivo = 0;
        }
        $id_perfilActivo = $this->sessionContainer->perfilActivo;
        $perfiles = $this->getPerfiles();
        
        
        $PerfilActivo = $perfiles[$id_perfilActivo];
        
        return $PerfilActivo;
    }
    
    public function setPerfilActivo($perfilActivo){
        $this->sessionContainer->perfilActivo = $perfilActivo;
    }
    
    public function getTamanioPaginacion()
    {
        $tamanio = $this->sessionContainer->tamanio;
        
        return $tamanio;
    }
    
    public function setTamanioPaginacion($tamanio)
    {
        $this->sessionContainer->tamanio = $tamanio;
    }
    
    public function cerrar()
    {
        unset($this->sessionContainer->perfilActivo);
        unset($this->sessionContainer->session);
    }
    
    public function esInterno()
    {
        $Perfil = $this->getPerfilActivo();
        if ($Perfil != null)
        {
            return $Perfil->esInterno();
        } else
        {
            return false;
        }
    }
    
}
