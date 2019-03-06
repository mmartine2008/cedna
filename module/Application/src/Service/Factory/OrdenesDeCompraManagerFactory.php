<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\OrdenesDeCompraManager;
use DBAL\Service\CatalogoManager;


class OrdenesDeCompraManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
        $catalogoManager = $container->get(CatalogoManager::class); 

        return new OrdenesDeCompraManager($entityManager, $catalogoManager);
    }
}
