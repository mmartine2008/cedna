<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\PerfilesManager;
use Application\Service\PermisosManager;
/**
 * Esta es el factory para OperadoresManager. Su propósito es crear una instancia 
 * del controlador e inyectar dependencias en él.
 */
class PermisosManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
        $perfilesManager = $container->get(PerfilesManager::class);

        return new PermisosManager($entityManager, $perfilesManager);
    }
}
