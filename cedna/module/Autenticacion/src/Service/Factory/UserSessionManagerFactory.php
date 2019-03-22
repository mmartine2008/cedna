<?php
namespace Autenticacion\Service\Factory;

use Interop\Container\ContainerInterface;
use Autenticacion\Service\UserSessionManager;


class UserSessionManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $sessionContainer = $container->get('RegistroUsuario');
                        
        return new UserSessionManager($sessionContainer);
    }
}
