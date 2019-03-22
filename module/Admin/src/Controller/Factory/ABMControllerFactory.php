<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\ABMController;

use Admin\Service\AccionManager;
use Admin\Service\OperacionManager;
use Admin\Service\OperacionAccionPerfilManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ABMControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accionManager = $container->get(AccionManager::class);
        $operacionManager = $container->get(OperacionManager::class);
        $operacionAccionPerfilManager = $container->get(OperacionAccionPerfilManager::class);
        
        return new ABMController($accionManager, $operacionManager, $operacionAccionPerfilManager);
    }
}
