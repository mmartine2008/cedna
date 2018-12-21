<?php
namespace Autenticacion\Controller\Factory;

use Interop\Container\ContainerInterface; use Autenticacion\Service\UserSessionManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Autenticacion\Controller\PerfilesController;
use Autenticacion\Service\PerfilesManager;
use Autenticacion\Service\RolesManager;
use Application\Service\PermisosManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class PerfilesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $permisosManager = $container->get(PermisosManager::class);
        $perfilesManager = $container->get(PerfilesManager::class);
        $rolesManager = $container->get(RolesManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        // Instantiate the controller and inject dependencies
        return new PerfilesController($permisosManager, $userSessionManager,$perfilesManager,$rolesManager);
    }
}