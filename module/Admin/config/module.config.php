<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'abm' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/abm',
                    'defaults' => [
                        'controller' => Controller\ABMController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'accion' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/accion[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\AccionController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'operacion' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/operacion[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\OperacionController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'operacionAccionPerfil' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/operacionAccionPerfil[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\OperacionAccionPerfilController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'tipo-pregunta' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/tipo-pregunta[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\TipoPreguntaController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'constraints' => [
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[a-zA-Z0-9_-]*',
                        ],
                        'may_terminate' => true,
                    ],
                    'generador-abm' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/generador-abm[/:action[/:id]]',
                            'defaults' => [
                                'controller' => Controller\GeneradorABMController::class,
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
            Controller\ABMController::class => Controller\Factory\ABMControllerFactory::class,
            Controller\AccionController::class => Controller\Factory\AccionControllerFactory::class,
            Controller\OperacionController::class => Controller\Factory\OperacionControllerFactory::class,
            Controller\OperacionAccionPerfilController::class => Controller\Factory\OperacionAccionPerfilControllerFactory::class,
            Controller\TipoPreguntaController::class => Controller\Factory\TipoPreguntaControllerFactory::class,
            Controller\GeneradorABMController::class => Controller\Factory\GeneradorABMControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\AccionManager::class => Service\Factory\AccionManagerFactory::class,
            Service\OperacionManager::class => Service\Factory\OperacionManagerFactory::class,            
            Service\OperacionAccionPerfilManager::class => Service\Factory\OperacionAccionPerfilManagerFactory::class,
            Service\TipoPreguntaManager::class => Service\Factory\TipoPreguntaManagerFactory::class,
            Service\GeneradorABMManager::class => Service\Factory\GeneradorABMManagerFactory::class,
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
            'admin/index/index' => __DIR__ . '/../view/admin/index/index.phtml',
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
