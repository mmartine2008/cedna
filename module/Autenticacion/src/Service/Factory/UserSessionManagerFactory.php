<?php
namespace Usuarios\Service\Factory;

use Interop\Container\ContainerInterface;
use Usuarios\Service\UserSessionManager;


class UserSessionManagerFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $sessionContainer = $container->get('RegistroUsuario');
                        
        return new UserSessionManager($sessionContainer);
    }
}
