<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Configuracion;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'configuracion' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/configuracion',
                    'defaults' => [
                        'controller' => Controller\ConfiguracionController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'perfiles' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/perfiles[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigPerfilesController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'parametros' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/parametros[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigParametrosController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'usuarios' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/usuarios[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigUsuariosController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'notificaciones-por-perfil' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/notificaciones-por-perfil[/:action]',
                            'defaults' => [
                                'controller' => Controller\ConfigNotifXPerfilController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'formularios' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/formularios[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigFormularioController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'secciones' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/secciones[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigFormularioController::class,
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
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\ConfiguracionController::class => Controller\Factory\ConfiguracionControllerFactory::class,
            Controller\ConfigPerfilesController::class => Controller\Factory\ConfigPerfilesControllerFactory::class,
            Controller\ConfigUsuariosController::class => Controller\Factory\ConfigUsuariosControllerFactory::class,
            Controller\ConfigNotifXPerfilController::class => Controller\Factory\ConfigNotifXPerfilControllerFactory::class,
            Controller\ConfigParametrosController::class => Controller\Factory\ConfigParametrosControllerFactory::class,
            Controller\ConfigFormularioController::class => Controller\Factory\ConfigFormularioControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ConfiguracionManager::class => Service\Factory\ConfiguracionManagerFactory::class,
            Service\ConfigUsuariosManager::class => Service\Factory\ConfigUsuariosManagerFactory::class,
            Service\ConfigFormularioManager::class => Service\Factory\ConfigFormularioManagerFactory::class,
            \Zend\I18n\Translator\TranslatorInterface::class => \Zend\I18n\Translator\TranslatorServiceFactory::class,
        ],
    ],

    'view_helpers' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class
        ]
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'configuracion/index/index' => __DIR__ . '/../view/configuracion/index/index.phtml',
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

];
