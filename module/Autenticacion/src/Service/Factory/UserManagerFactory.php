<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use Autenticacion\Service\UserManager;
use Autenticacion\Service\PerfilesManager;

class UserManagerFactory
{
    
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        $config = $container->get('config');
        
        if (!(isset($config['smtp_options'])))
        {
            throw new \Exception("Opciones de envio de correo (SMTP) no definidas", 1);
        }        
            
        $perfilesManager = $container->get(PerfilesManager::class);
        return new UserManager($entityManager, $config['smtp_options'], $perfilesManager);
    }
}
