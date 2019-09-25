<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\EmpresaContratistaController;

use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\EmpresaContratistaManager;
use Application\Service\PermisosManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class EmpresaContratistaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $empresasManager = $container->get(EmpresaContratistaManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new EmpresaContratistaController($catalogoManager, $userSessionManager, $translator, $permisosManager, $empresasManager);
    }
}
