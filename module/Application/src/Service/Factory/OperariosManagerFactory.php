<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\OperariosManager;
use DBAL\Service\CatalogoManager;
use Application\Service\TareasManager;


class OperariosManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
        $catalogoManager = $container->get(CatalogoManager::class); 
        $mailManager = $container->get(MailManager::class); 

        return new OperariosManager($entityManager, $catalogoManager, $mailManager);
    }
}
