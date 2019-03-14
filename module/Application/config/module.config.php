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
            'abm' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/abm',
                    'defaults' => [
                        'controller' => Controller\ABMController::class,
                        'action'     => 'abm',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'entidad' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:entidad[/:action[/:id]]',
                            'defaults' => [
                                'action'     => 'listar',
                            ],
                        ],
                        'constraints' => [
                            'entidad' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
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
            Controller\ABMController::class => Controller\Factory\ABMControllerFactory::class,
            Controller\CednaController::class => Controller\Factory\CednaControllerFactory::class,
            Controller\OperariosController::class => Controller\Factory\OperariosControllerFactory::class,
            Controller\OrganigramaController::class => Controller\Factory\OrganigramaControllerFactory::class,
            Controller\TareasController::class => Controller\Factory\TareasControllerFactory::class,
            Controller\OrdenesDeCompraController::class => Controller\Factory\OrdenesDeCompraControllerFactory::class,
            Controller\PlanificacionController::class => Controller\Factory\PlanificacionControllerFactory::class,
            Controller\MailController::class => Controller\Factory\MailControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'translator' => \Zend\I18n\Translator\TranslatorServiceFactory::class,
            Service\AccionManager::class => Service\Factory\AccionManagerFactory::class,
            Service\OperacionManager::class => Service\Factory\OperacionManagerFactory::class,
            Service\UsuariosManager::class => Service\Factory\UsuariosManagerFactory::class,
            Service\PerfilesManager::class => Service\Factory\PerfilesManagerFactory::class,
            Service\OperacionAccionPerfilManager::class => Service\Factory\OperacionAccionPerfilManagerFactory::class,
            Service\OperariosManager::class => Service\Factory\OperariosManagerFactory::class,
            Service\OrganigramaManager::class => Service\Factory\OrganigramaManagerFactory::class,
            Service\TareasManager::class => Service\Factory\TareasManagerFactory::class,
            Service\OrdenesDeCompraManager::class => Service\Factory\OrdenesDeCompraManagerFactory::class,
            Service\MailManager::class => Service\Factory\MailManagerFactory::class,
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
