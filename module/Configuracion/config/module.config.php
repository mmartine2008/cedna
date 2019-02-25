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
                    'tipo-pregunta' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/tipo-pregunta[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\ConfigTipoPreguntaController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
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
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\ConfiguracionController::class => Controller\Factory\ConfiguracionControllerFactory::class,
            Controller\ConfigTipoPreguntaController::class => Controller\Factory\ConfigTipoPreguntaControllerFactory::class,
            Controller\ConfigPerfilesController::class => Controller\Factory\ConfigPerfilesControllerFactory::class,
            Controller\ConfigUsuariosController::class => Controller\Factory\ConfigUsuariosControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ConfiguracionManager::class => Service\Factory\ConfiguracionManagerFactory::class,
            Service\ConfigUsuariosManager::class => Service\Factory\ConfigUsuariosManagerFactory::class,
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
