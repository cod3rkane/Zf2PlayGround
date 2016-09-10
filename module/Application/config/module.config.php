<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\Api\SintegraControllerFactory;
use Application\Controller\AuthControllerFactory;
use Application\Controller\PanelControllerFactory;
use Interop\Container\ContainerInterface;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'panel' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/panel',
                    'defaults' => [
                        'controller' => Controller\PanelController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'panelList' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/panel/list',
                    'defaults' => [
                        'controller' => Controller\PanelController::class,
                        'action' => 'list',
                    ],
                ],
            ],
            'auth' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'app.user.api' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/sintegra[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => Controller\Api\SintegraController::class,
                    ]
                ],
            ],
            'app.sintegra.api' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/sintegra/delete[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => Controller\Api\SintegraController::class,
                        'action' => 'delete'
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\Api\SintegraController::class => SintegraControllerFactory::class,
            Controller\AuthController::class => AuthControllerFactory::class,
            Controller\PanelController::class => PanelControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy'
        ],
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
