<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use Autenticacion\Service\RolesManager;


class RolesManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
                        
        return new RolesManager($entityManager);
    }
}
