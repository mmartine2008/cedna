<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\GeneradorABMController;

use Admin\Service\GeneradorABMManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\PermisosManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class GeneradorABMControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $generadorABMManager = $container->get(GeneradorABMManager::class);
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new GeneradorABMController($catalogoManager, $userSessionManager, $translator, $generadorABMManager, $permisosManager);
    }
}
