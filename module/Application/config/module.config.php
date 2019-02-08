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
                        'controller' => Controller\ABMController::class, //Cambiar por un nuevo indexController
                        'action'     => 'login',
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
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ABMController::class => Controller\Factory\ABMControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\AccionManager::class => Service\Factory\AccionManagerFactory::class,
            Service\OperacionManager::class => Service\Factory\OperacionManagerFactory::class,
            Service\UsuariosManager::class => Service\Factory\UsuariosManagerFactory::class,
            Service\PerfilesManager::class => Service\Factory\PerfilesManagerFactory::class,
            Service\OperacionAccionPerfilManager::class => Service\Factory\OperacionAccionPerfilManagerFactory::class,
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

];
