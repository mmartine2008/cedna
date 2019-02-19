<?php
namespace Configuracion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Controller\ConfigUsuariosController;

use DBAL\Service\CatalogoManager;
use Configuracion\Service\ConfigUsuariosManager;
use Autenticacion\Service\UserSessionManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConfigUsuariosControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $configUsuariosManager = $container->get(ConfigUsuariosManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        
        return new ConfigUsuariosController($catalogoManager, $configUsuariosManager, $userSessionManager);
    }
}
