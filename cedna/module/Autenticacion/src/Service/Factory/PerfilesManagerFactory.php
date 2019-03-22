<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use Autenticacion\Service\PerfilesManager;


class PerfilesManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
                        
        return new PerfilesManager($entityManager);
    }
}
