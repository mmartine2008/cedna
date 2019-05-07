<?php

/**
 * Este servicio es el responsable del manejo de permisos de cada uno de
 * los perfiles existentes. Este manejo se realiza mediante ACL.
 *  
 * @author      
 */ 

namespace Application\Service;


use Zend\Permissions\Acl\Acl;


/**
 * Description of OperadoresManager
 *
 * @author juanom07
 */
class PermisosManager {
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    private $perfilesManager;

    protected $controlesComunes = [
        'Autenticacion\Controller\AuthController', 
        'Formulario\Controller\BaseFormularioController',
        'Formulario\Controller\FormularioController', 
        //no se donde van: 
        'Application\Controller\CednaController', 
        'Application\Controller\MailController',
    ];
    


    protected $controlersAdmin = [
                'Application\Controller\InduccionesController', 
                'Application\Controller\OperariosController', 
                'Application\Controller\OrganigramaController', 
                'Configuracion\Controller\ConfigFormularioController', 
                'Configuracion\Controller\ConfigNotifXPerfilController', 
                'Configuracion\Controller\ConfigParametrosController', 
                'Configuracion\Controller\ConfigPerfilesController', 
                'Configuracion\Controller\ConfigPreguntaController', 
                'Configuracion\Controller\ConfiguracionController', 
                'Configuracion\Controller\ConfigUsuariosController', 
                'Admin\Controller\ABMController', 
                'Admin\Controller\AccionController', 
                'Admin\Controller\GeneradorABMController', 
                'Admin\Controller\OperacionAccionPerfilController', 
                'Admin\Controller\OperacionController', 
                'Admin\Controller\TipoPreguntaController', 
            ];
    
    protected $controlersExterno = [
        'Application\Controller\OrdenesDeCompraController',
        'Application\Controller\PlanificacionController',
        'Application\Controller\TareasController',
            ];
      
    private $acl;
   
    public function __construct($entityManager, $perfilesManager)
    {
        $this->entityManager = $entityManager;
        $this->perfilesManager = $perfilesManager;
        
        $this->iniciarACL();
    }
    
    /**
     * Agrego como perfiles, todo los perfiles posibles
     */
    private function addPerfiles()
    {
        $perfiles = $this->perfilesManager->getListado();
        
        foreach ($perfiles as $perfil)
        {
            if (!$this->acl->hasRole($perfil->getNombre()))
            {
                $this->acl->addRole($perfil->getNombre());
            }
        }
    }
    
    /**
     * Recupera todos los perfiles que son externos, por ahora con un IF,
     * luego con un atributo
     */
    private function getPerfilesExternos()
    {
        $output = [];
        $perfiles = $this->perfilesManager->getListado();
        foreach ($perfiles as $perfil)
        {
            // if (!$perfil->esInterno())
           if ($perfil->getNombre() != 'Administrador')
            {
                $output[] = $perfil;
            }
        }
        
        return $output;
    }
    
    private function getPerfilesInternos()
    {
        $output = [];
        $perfiles = $this->perfilesManager->getListado();
        foreach ($perfiles as $perfil)
        {
            // if ($perfil->esInterno())
           if ($perfil->getNombre() == 'Administrador')
            {
                $output[] = $perfil;
            }
        }
        
        return $output;
    }    

    /**
     * Agrego todos los controladores posibles para internos, Admin y otros
     */
    private function addRecursosInternos()
    {
        $perfilesInternos = $this->getPerfilesInternos();
        
        foreach ($this->controlersAdmin as $controller)
        {
            if (!$this->acl->hasResource($controller))
            {
                $this->acl->addResource($controller);
            }
            foreach ($perfilesInternos as $perfil)
            {
                $this->acl->allow($perfil->getNombre(), $controller);
            }
        }
    }

    /**
     * Siendo $nombrePefil distinto de Administrador, le agrega todos los controladores
     * @param type $nombrePerfil
     */
    private function addPermisoRecursoPerfilExterno($nombrePerfil)
    {
        foreach ($this->controlersExterno as $controller)
        {
            if (!$this->acl->hasResource($controller))
            {
                $this->acl->addResource($controller);
            }
            $this->acl->allow($nombrePerfil, $controller);
        }                                
    }
 
    /**
     * Agrego todos los controladores posibles como externos
     * Corresponden a las operaciones de Transportistas, Chofer, Generador,
     * operador
     */
    private function addRecursosComunes()
    {
        // Agrego todos los controlers externos:
        $perfiles = $this->perfilesManager->getListado();
        foreach ($perfiles as $perfil)
        {
            $nombrePerfil = $perfil->getNombre();
            foreach ($this->controlesComunes as $controller)
            {
                if (!$this->acl->hasResource($controller))
                {
                    $this->acl->addResource($controller);
                }                
                $this->acl->allow($nombrePerfil, $controller);
            }            
        }
    }
    
    /**
     * Agrego todos los controladores posibles como externos
     * Corresponden a las operaciones de Transportistas, Chofer, Generador,
     * operador
     */
    private function addRecursosExterno()
    {
        // Agrego todos los controlers externos:
        $perfiles = $this->getPerfilesExternos();
        foreach ($perfiles as $perfil)
        {
            $nombrePerfil = $perfil->getNombre();
            $this->addPermisoRecursoPerfilExterno($nombrePerfil);
        }
    }
    
    private function iniciarACL()
    {
        $this->acl = new Acl();
        
        $this->addPerfiles();
        
        $this->addRecursosComunes();
        
        $this->addRecursosInternos();
        
        $this->addRecursosExterno();
    }
    
//     public function verificar($perfil, $recurso, $method = null)
//     {
//         $resultado = $this->acl->isAllowed($perfil, $recurso);

//         return $resultado;
//     }
       
// /**
//      * El metodo login es el principal metodo que es valido cuando no se esta logueado,
//      * pero tambien hay otros
//      * 
//      * @param type $controller
//      * @param type $action
//      * @param type $method
//      */
//     public function validarLogin($controller, $action, $method)
//     {
//        if  ($controller == 'Usuarios\Controller\AuthController')
//         {
//             if (($action == 'login') || 
//                 ($action == 'cambiarperfilactivoAction') || 
//                 ($action == 'registro') || 
//                 ($action == 'logout') 
//                 || ($action == 'sendmail') 
//                 )
//             {
//                 return true;
//             }
//         } 
        
//         return false;
//     }
}