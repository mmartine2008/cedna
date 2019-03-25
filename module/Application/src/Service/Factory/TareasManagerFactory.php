<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\TareasManager;
use DBAL\Service\CatalogoManager;
use Application\Service\MailManager;

class TareasManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
        $catalogoManager = $container->get(CatalogoManager::class); 
        $mailManager = $container->get(MailManager::class); 

        return new TareasManager($entityManager, $catalogoManager, $mailManager);
    }
}