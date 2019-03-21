<?php
namespace Formulario\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Formulario\Service\FormularioManager;
use DBAL\Service\CatalogoManager;


class FormularioManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $catalogoManager = $container->get(CatalogoManager::class); 
        $config = $container->get('config');
        if (!(isset($config['datos_empresa'])))
        {
            throw new \Exception("Datos de empresa no definidos", 1);
        }
                        
        return new FormularioManager($entityManager, $catalogoManager, $config['datos_empresa']);
        // return new FormularioManager($entityManager, $catalogoManager);

    }
}
