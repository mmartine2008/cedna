<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\TipoPreguntaController;

use Admin\Service\TipoPreguntaManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Application\Service\PermisosManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class TipoPreguntaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tipoPreguntaManager = $container->get(TipoPreguntaManager::class);
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $permisosManager = $container->get(PermisosManager::class);
        
        return new TipoPreguntaController($catalogoManager, $tipoPreguntaManager, $userSessionManager, $translator, $permisosManager);
    }
}
