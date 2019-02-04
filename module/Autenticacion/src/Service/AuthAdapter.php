<?php
namespace Autenticacion\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;

class AuthAdapter implements AdapterInterface
{
    /**
     * Nombre de usuario.
     * @var string 
     */
    private $nombreUsuario;
    
    /**
     * Password
     * @var string 
     */
    private $password;
    
    /**
     * Manejador de usuarios 
     */
    private $userManager;
    
    private $perfiles;
        
    /**
     * Constructor.
     */
    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }
    
    /**
     * Sets user nombreUsuario.     
     */
    public function setNombreUsuario($nombreUsuario) 
    {
        $this->nombreUsuario = $nombreUsuario;        
    }

    /**
     * Sets perfiles.     
     */
    public function setPerfiles($perfiles) 
    {
        $this->perfiles = $perfiles;        
    }

    /**
     * Gets perfiles.     
     */
    public function getPerfiles() 
    {
        return $this->perfiles;        
    }
    
    /**
     * Sets password.     
     */
    public function setPassword($password) 
    {
        $this->password = (string)$password;        
    }
    
    /*
     * Valida la existencia del usuario
     */
    private function autenticarIdentidad($Usuario)
    {

        if ($Usuario == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND, 
                null, 
                ['No existe el usuario']);        
        }   

        return null;
    }
  
    /*
     * Valida que no este bloqueado
     */
    private function autenticarBloqueo($Usuario)
    {

        if ($Usuario->getBloqueado() == '1') {
            return new Result(
                Result::FAILURE, 
                null, 
                ['El usuario esta bloqueado.']);        
        }  
        
        return null;
    }
 
    /*
     * Valida que no este bloqueado
     */
    private function autenticarPassword($Usuario)
    {

        $bcrypt = new Bcrypt();
        $passwordHash = $Usuario->getPassword();
        
        if (!$bcrypt->verify($this->password, $passwordHash)) {

        return new Result(
                Result::FAILURE_CREDENTIAL_INVALID, 
                null, 
                ['Clave incorrecta']);        
        }   
        
        return null;
    }
    
    /**
     * Recorre todas las validaciones y retorna un resultado
     * @param type $Usuario
     */
    private function resultadoValidaciones($Usuario)
    {
        // $Resultado = $this->autenticarIdentidad($Usuario);
        // if ($Resultado)
        // {
        //     return $Resultado;
        // } 

        // $Resultado = $this->autenticarBloqueo($Usuario);
        // if ($Resultado)
        // {
        //     return $Resultado;
        // } 

        // $Resultado = $this->autenticarPassword($Usuario);
        // if ($Resultado)
        // {
        //     return $Resultado;
        // }             

        return new Result(
                    Result::SUCCESS, 
                    $this->nombreUsuario, 
                    ['Autenticacion correcta.']);        
    }

    public function authenticate()
    {                
        
        $Usuario = $this->userManager->getUser($this->nombreUsuario);

        $Resultado = $this->resultadoValidaciones($Usuario);
        
        if ($Usuario)
        {
            $Perfiles = $this->userManager->getPerfilesActivos($Usuario);
            
            $this->setPerfiles($Perfiles);
        }
        
        return $Resultado;        
    }
}


