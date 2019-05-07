<?php
namespace Configuracion\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Controller\ConfigPreguntaController;

use DBAL\Service\CatalogoManager;
use Configuracion\Service\ConfigFormularioManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\PermisosManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConfigPreguntaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $configuracionManager = $container->get(ConfigFormularioManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new ConfigPreguntaController($catalogoManager, $configuracionManager, $userSessionManager, $translator, $permisosManager);
    }
}
