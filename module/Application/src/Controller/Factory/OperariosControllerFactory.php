<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\OperariosController;

use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\OperariosManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class OperariosControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $operariosManager = $container->get(OperariosManager::class);
        $translator = $container->get('translator');
        
        return new OperariosController($catalogoManager, $userSessionManager, $operariosManager, $translator);
    }
}
