<?php
namespace Configuracion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Controller\ConfigParametrosController;

use DBAL\Service\CatalogoManager;
use Configuracion\Service\ConfiguracionManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\PermisosManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConfigParametrosControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $configuracionManager = $container->get(ConfiguracionManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new ConfigParametrosController($catalogoManager, $configuracionManager, $userSessionManager, $translator, $permisosManager);
    }
}
