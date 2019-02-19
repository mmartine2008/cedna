<?php
namespace Configuracion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Controller\ConfigPerfilesController;

use DBAL\Service\CatalogoManager;
use Configuracion\Service\ConfiguracionManager;
use Autenticacion\Service\UserSessionManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConfigPerfilesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $configuracionManager = $container->get(ConfiguracionManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        
        return new ConfigPerfilesController($catalogoManager, $configuracionManager, $userSessionManager);
    }
}
