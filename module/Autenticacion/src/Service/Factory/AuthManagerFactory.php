<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Autenticacion\Service\AuthManager;
use Zend\Session\SessionManager;

class AuthManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        
        $authenticationService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $sessionManager = $container->get(SessionManager::class);

        $config = $container->get('Config');
        if (isset($config['access_filter']))
            $config = $config['access_filter'];
        else
            $config = [];

        $afipManager = null; //$container->get(AuthAfip::class); 

        return new AuthManager($authenticationService, $sessionManager, $config, $afipManager);   
    }
}
