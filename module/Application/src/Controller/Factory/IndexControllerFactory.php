<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\IndexController;

use Application\Service\AccionManager;
use Application\Service\OperacionManager;
use Application\Service\UsuariosManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $accionManager = $container->get(AccionManager::class);
        $operacionManager = $container->get(OperacionManager::class);
        $usuariosManager = $container->get(UsuariosManager::class);
        
        return new IndexController($accionManager, $operacionManager, $usuariosManager);
    }
}
