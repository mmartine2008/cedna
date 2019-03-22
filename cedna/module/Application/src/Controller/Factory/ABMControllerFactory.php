<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\ABMController;

use Application\Service\AccionManager;
use Application\Service\OperacionManager;
use Application\Service\UsuariosManager;
use Application\Service\PerfilesManager;
use Application\Service\OperacionAccionPerfilManager;

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
        $usuariosManager = $container->get(UsuariosManager::class);
        $perfilesManager = $container->get(PerfilesManager::class);
        $operacionAccionPerfilManager = $container->get(OperacionAccionPerfilManager::class);
        
        return new ABMController($accionManager, $operacionManager, 
                $usuariosManager, $perfilesManager, $operacionAccionPerfilManager);
    }
}
