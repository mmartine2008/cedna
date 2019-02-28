<?php
namespace Autenticacion;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;


return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
    
            ],            
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'sendmail' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/sendmail',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'sendmail',
                    ],
                ],
            ],            
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'reset-password' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/reset-password[/:userPass]',
                    'constraints' => [
                        'userPass' => '[a-zA-Z0-9\_]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'resetPassword',
                    ],
                ],
            ],
            'usuario' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/usuario[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'edit',
                    ],
                ],
            ],
            'registro' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/registro',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'registro',
                    ],
                ],
            ],
            'auth' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/auth[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                    ],
                ],
            ],
            'roles' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/roles',
                    'defaults' => [
                        'controller' => Controller\RolesController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'accion' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '[/:action[/:param1[/:param2]]]',
                            'constraints' => [
                                'action' => '(?!alta|editar)[a-zA-Z][a-zA-Z0-9_-]*',
                                'param1' => '[a-zA-Z0-9_-]*',
                                'param2' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                    'alta' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/alta',
                            'defaults' => [
                                'controller' => Controller\RolesController::class,
                                'action' => 'alta',
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                    'editar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/editar[/:id]',
                            'defaults' => [
                                'controller' => Controller\RolesController::class,
                                'action' => 'editar',
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
            'perfiles' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/perfiles',
                    'defaults' => [
                        'controller' => Controller\PerfilesController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'accion' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '[/:action[/:param1[/:param2]]]',
                            'constraints' => [
                                'action' => '(?!alta|editar)[a-zA-Z][a-zA-Z0-9_-]*',
                                'param1' => '[a-zA-Z0-9_-]*',
                                'param2' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                    'alta' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/alta',
                            'defaults' => [
                                'controller' => Controller\PerfilesController::class,
                                'action' => 'alta',
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                    'editar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/editar[/:id]',
                            'defaults' => [
                                'controller' => Controller\PerfilesController::class,
                                'action' => 'editar',
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Controller\Factory\AuthControllerFactory::class,
                         
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
//    'access_filter' => [
//        'controllers' => [
//            Controller\LoginController::class => [
//                // Give access to "resetPassword", "message" and "setPassword" actions
//                // to anyone.
//                ['actions' => ['resetPassword', 'message', 'setPassword'], 'allow' => '*'],
//                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
//                ['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
//            ],
//        ]
//    ],
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,
            Service\AuthManager::class => Service\Factory\AuthManagerFactory::class,
            Service\UserManager::class => Service\Factory\UserManagerFactory::class,
            Service\EmpresasManager::class => Service\Factory\EmpresasManagerFactory::class,
            Service\RolesManager::class => Service\Factory\RolesManagerFactory::class,
            Service\PerfilesManager::class => Service\Factory\PerfilesManagerFactory::class,
            Service\AuthAdapter::class => Service\Factory\AuthAdapterFactory::class,
            Service\UserSessionManager::class => Service\Factory\UserSessionManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
   'session_containers' => [
        'RegistroUsuario'
    ],    
    
    'view_helpers' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class
        ]
    ],   

];
