<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface; 
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\MailManager;


class MailManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_default'); 
        
        $config = $container->get('config');

        if (!(isset($config['smtp_options'])))
        {
            throw new \Exception("Opciones de envio de correo (SMTP) no definidas", 1);
        }

        return new MailManager($entityManager, $config['smtp_options']);
    }
}
