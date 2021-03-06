<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Formulario;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'formulario' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/formulario[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\FormularioController::class,
                        'action'     => 'index',
                    ],
                ],
                'constraints' => [
                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id' => '[a-zA-Z0-9_-]*',
                ],
            ],
            'imprimir' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/imprimir/:id',
                    'defaults' => [
                        'action' => 'imprimir',
                        'controller' => Controller\FormularioController::class,
                    ],
                    'constraints' => [
                        'id' => '[1-9]\d*',
                    ],
                ],
            ],
            'mostrar_imagen' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/mostrar_imagen/:id',
                    'defaults' => [
                        'action' => 'mostrarImagen',
                        'controller' => Controller\FormularioController::class,
                    ],
                    'constraints' => [
                        'id' => '[1-9]\d*',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\BaseFormularioController::class => Controller\Factory\BaseFormularioControllerFactory::class,
            Controller\FormularioController::class => Controller\Factory\FormularioControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\FormularioManager::class => Service\Factory\FormularioManagerFactory::class,
            Service\CednaTcpdf::class => Service\Factory\CednaTcpdfFactory::class

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
