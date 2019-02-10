<?php
namespace Configuracion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Controller\ConfigPerfilesController;

use Configuracion\Service\ConfiguracionManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConfigPerfilesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuracionManager = $container->get(ConfiguracionManager::class);
        
        return new ConfigPerfilesController($configuracionManager);
    }
}
