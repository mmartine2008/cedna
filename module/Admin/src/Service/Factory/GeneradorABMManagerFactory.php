<?php
namespace Admin\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Service\GeneradorABMManager;


class GeneradorABMManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
                        
        return new GeneradorABMManager($entityManager);
    }
}
