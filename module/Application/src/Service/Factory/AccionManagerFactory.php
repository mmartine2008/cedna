<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface; 
use Application\Service\AccionManager;


class AccionManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
                        
        return new AccionManager($entityManager);
    }
}
