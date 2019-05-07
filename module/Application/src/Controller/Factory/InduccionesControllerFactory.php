<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\InduccionesController;

use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\InduccionesManager;
use Application\Service\PermisosManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class InduccionesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $induccionesManager = $container->get(InduccionesManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new InduccionesController($catalogoManager, $userSessionManager, $induccionesManager, $translator, $permisosManager);
    }
}
