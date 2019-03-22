<?php
namespace Autenticacion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Autenticacion\Service\UserSessionManager; 
use Autenticacion\Controller\AuthController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Autenticacion\Service\AuthManager;
use Autenticacion\Service\UserManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $permisosManager = null; //$container->get(PermisosManager::class);
        $authManager = $container->get(AuthManager::class);
        $userManager = $container->get(UserManager::class);
        $empresasManager = null; //$container->get(EmpresasManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        
        return new AuthController($permisosManager, $authManager, $userManager, $userSessionManager, $empresasManager);
    }
}
