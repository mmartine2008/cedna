<?php
namespace Configuracion\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Service\ConfigFormularioManager;
use DBAL\Service\CatalogoManager;


class ConfigFormularioManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 

        $catalogoManager = $container->get(CatalogoManager::class);
                        
        return new ConfigFormularioManager($entityManager, $catalogoManager);
    }
}
