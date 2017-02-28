<?php
namespace EduBet;

return [
    'router' => [
        'routes' => [
            'matches' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/matches',
                    'defaults' => array(
                        'controller' => 'EduBet\Controller\IndexController',
                        'action'     => 'index',
                    ),
                ),
            ),
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
            Match\Service\MatchService::class => Match\Service\MatchServiceFactory::class,
            Scrapy\Service\ScrapyService::class => Scrapy\Service\ScrapyServiceFactory::class,
            Team\Service\TeamService::class => Team\Service\TeamServiceFactory::class,
            Tournament\Service\TournamentService::class => Tournament\Service\TournamentServiceFactory::class,
            WhoScored\Command\PreviewOverview::class => WhoScored\Command\PreviewOverviewFactory::class,
            WhoScored\Service\WhoScoredPreviewOverviewService::class => WhoScored\Service\WhoScoredPreviewOverviewServiceFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
        ],
    ],
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__.'/../src/EduBet/Match/Entity',
                    __DIR__.'/../src/EduBet/Result/Entity',
                    __DIR__.'/../src/EduBet/Scrapy/Entity',
                    __DIR__.'/../src/EduBet/Team/Entity',
                    __DIR__.'/../src/EduBet/Tournament/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'EduBet\Match' => 'my_annotation_driver',
                    'EduBet\Result' => 'my_annotation_driver',
                    'EduBet\Scrapy' => 'my_annotation_driver',
                    'EduBet\Team' => 'my_annotation_driver',
                    'EduBet\Tournament' => 'my_annotation_driver',
                )
            )
        )
    ),
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
