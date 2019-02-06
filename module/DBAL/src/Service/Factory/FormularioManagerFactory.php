<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use DBAL\Service\FormularioManager;


class FormularioManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
                        
        return new FormularioManager($entityManager);
    }
}
