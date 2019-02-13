<?php
namespace Configuracion\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Configuracion\Service\ConfigUsuariosManager;
use DBAL\Service\CatalogoManager;


class ConfigUsuariosManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 

        $catalogoManager = $container->get(CatalogoManager::class);
                        
        return new ConfigUsuariosManager($entityManager, $catalogoManager);
    }
}
