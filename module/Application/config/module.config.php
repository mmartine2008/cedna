<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\ABMController::class, 
                        'action'     => 'login',
                    ],
                ],
            ],
            'index' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/index',
                    'defaults' => [
                        'controller' => Controller\CednaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'operarios' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/operarios[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\OperariosController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'inducciones' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/inducciones[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\InduccionesController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'organigrama' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/organigrama',
                    'defaults' => [
                        'controller' => Controller\OrganigramaController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'nodos' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/nodos[/:action[/:id]]',
                            'defaults' => [
                                'action'     => 'nodos',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'autoridades' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/autoridades[/:action[/:id]]',
                            'defaults' => [
                                'action'     => 'autoridades',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'dibujar' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/dibujar',
                            'defaults' => [
                                'action'     => 'dibujar',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'tareas' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/tareas[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\TareasController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'herramientas' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/herramientas[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\HerramientasController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'planificacion' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/planificacion[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PlanificacionController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'ordenes-de-compra' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/ordenes-de-compra[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\OrdenesDeCompraController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
            'mail' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/mail[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\MailController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
                'may_terminate' => true,
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\CednaController::class => Controller\Factory\CednaControllerFactory::class,
            Controller\OperariosController::class => Controller\Factory\OperariosControllerFactory::class,
            Controller\OrganigramaController::class => Controller\Factory\OrganigramaControllerFactory::class,
            Controller\TareasController::class => Controller\Factory\TareasControllerFactory::class,
            Controller\OrdenesDeCompraController::class => Controller\Factory\OrdenesDeCompraControllerFactory::class,
            Controller\PlanificacionController::class => Controller\Factory\PlanificacionControllerFactory::class,
            Controller\MailController::class => Controller\Factory\MailControllerFactory::class,
            Controller\InduccionesController::class => Controller\Factory\InduccionesControllerFactory::class,
            Controller\HerramientasController::class => Controller\Factory\HerramientasControllerFactory::class,        
        ],
    ],
    'service_manager' => [
        'factories' => [
            'translator' => \Zend\I18n\Translator\TranslatorServiceFactory::class,
            Service\UsuariosManager::class => Service\Factory\UsuariosManagerFactory::class,
            Service\PerfilesManager::class => Service\Factory\PerfilesManagerFactory::class,
            Service\OperariosManager::class => Service\Factory\OperariosManagerFactory::class,
            Service\OrganigramaManager::class => Service\Factory\OrganigramaManagerFactory::class,
            Service\TareasManager::class => Service\Factory\TareasManagerFactory::class,
            Service\OrdenesDeCompraManager::class => Service\Factory\OrdenesDeCompraManagerFactory::class,
            Service\MailManager::class => Service\Factory\MailManagerFactory::class,
            Service\InduccionesManager::class => Service\Factory\InduccionesManagerFactory::class,
            Service\PermisosManager::class => Service\Factory\PermisosManagerFactory::class,
            Service\HerramientasManager::class => Service\Factory\HerramientasManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'session_containers' => [
        'RegistroUsuario'
    ],

    'translator' => [
        'locale' => 'es_ES',
        'translation_file_patterns' => [
            [
                'base_dir' => \getcwd() .'/data/language/phpArray',
                'type'     => 'phpArray',
                'pattern'  => '%s.php',
            ],
            [
                'base_dir' => \getcwd() .'/data/language/gettext',
                'type'     => 'gettext',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
];
