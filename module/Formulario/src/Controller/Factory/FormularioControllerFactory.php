<?php
namespace Formulario\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Formulario\Controller\FormularioController;

use Formulario\Service\FormularioManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class FormularioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $FormularioManager = $container->get(FormularioManager::class);
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $tcpdf = $container->get(\TCPDF::class);
        $renderer = $container->get(RendererInterface::class);        

        
        return new FormularioController($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer);
    }
}
