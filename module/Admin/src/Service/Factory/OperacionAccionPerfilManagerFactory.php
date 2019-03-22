<?php
namespace Admin\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;

use Admin\Service\AccionManager;
use Admin\Service\OperacionManager;
use Admin\Service\OperacionAccionPerfilManager;
use Application\Service\PerfilesManager;


class OperacionAccionPerfilManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 

        $accionManager = $container->get(AccionManager::class);
        $operacionManager = $container->get(OperacionManager::class);
        $perfilesManager = $container->get(PerfilesManager::class);
                        
        return new OperacionAccionPerfilManager($entityManager, $accionManager, $operacionManager, $perfilesManager);
    }
}
