<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\OperacionController;

use Admin\Service\OperacionManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class OperacionControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $operacionManager = $container->get(OperacionManager::class);
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        
        return new OperacionController($operacionManager, $catalogoManager, $userSessionManager, $translator);
    }
}
