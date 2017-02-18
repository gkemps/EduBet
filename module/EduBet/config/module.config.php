<?php
namespace EduBet;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [

        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'preview-overview' => [
                    'options' => [
                        'route'    => 'preview-overview',
                        'defaults' => [
                            'controller' => 'EduBet\WhoScored\WhoScoredController',
                            'action'     => 'previewOverview',
                        ],
                    ],
                ],
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            WhoScored\Command\PreviewOverview::class => WhoScored\Command\PreviewOverviewFactory::class,
            WhoScored\Service\WhoScoredPreviewOverviewService::class => WhoScored\Service\WhoScoredPreviewOverviewServiceFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
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
];
