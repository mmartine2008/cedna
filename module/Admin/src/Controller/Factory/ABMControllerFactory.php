<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\ABMController;

use Admin\Service\AccionManager;
use Admin\Service\OperacionManager;
use Admin\Service\OperacionAccionPerfilManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\PermisosManager;

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
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);

        
        return new ABMController($accionManager, $operacionManager, $operacionAccionPerfilManager, 
                                $catalogoManager, $userSessionManager, $translator, $permisosManager);
    }
}
