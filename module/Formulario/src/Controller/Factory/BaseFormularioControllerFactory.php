<?php
namespace Formulario\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Formulario\Controller\BaseFormularioController;

use Formulario\Service\FormularioManager;
use DBAL\Service\CatalogoManager;
use Autenticacion\Service\UserSessionManager;
use Zend\View\Renderer\RendererInterface;
use Formulario\Service\CednaTcpdf;
use Application\Service\PermisosManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class BaseFormularioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $FormularioManager = $container->get(FormularioManager::class);
        $catalogoManager = $container->get(CatalogoManager::class);
        $userSessionManager = $container->get(UserSessionManager::class);
        $translator = $container->get('translator');
        $tcpdf = $container->get(CednaTcpdf::class);

        $renderer = $container->get(RendererInterface::class);    
        $permisosManager = $container->get(PermisosManager::class);

        return new BaseFormularioController($FormularioManager, $catalogoManager, $userSessionManager, $translator, $tcpdf, $renderer, $permisosManager);
    }
}
