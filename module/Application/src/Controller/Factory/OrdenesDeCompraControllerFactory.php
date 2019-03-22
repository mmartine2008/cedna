<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\OrdenesDeCompraController;

use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\OrdenesDeCompraManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class OrdenesDeCompraControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $ordenesDeCompraManager = $container->get(OrdenesDeCompraManager::class);
        $translator = $container->get('translator');
        
        return new OrdenesDeCompraController($catalogoManager, $userSessionManager, $ordenesDeCompraManager, $translator);
    }
}
