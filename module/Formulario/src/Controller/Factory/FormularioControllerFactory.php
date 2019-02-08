<?php
namespace Formulario\Controller\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Formulario\Controller\FormularioController;

use Formulario\Service\FormularioManager;


/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class FormularioControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $FormularioManager = $container->get(FormularioManager::class);
        
        return new FormularioController($FormularioManager);
    }
}
