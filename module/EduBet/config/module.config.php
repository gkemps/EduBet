<?php
namespace EduBet;

return [
    'router' => [
        'routes' => [
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'EduBet\Controller\IndexController',
                        'action'     => 'index',
                    ),
                ),
            ),
            'fixtures' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/programma',
                    'defaults' => array(
                        'controller' => 'EduBet\Controller\IndexController',
                        'action'     => 'fixtures',
                    ),
                ),
            ),
            'results' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/uitslagen',
                    'defaults' => array(
                        'controller' => 'EduBet\Controller\IndexController',
                        'action'     => 'results',
                    ),
                ),
            ),
        ],
    ],
    'service_manager' => [
        'factories' => [
            Betfair\Command\BetfairOdds::class => Betfair\Command\BetfairOddsFactory::class,
            Betfair\Service\BetfairService::class => Betfair\Service\BetfairServiceFactory::class,
            Odds\Service\OddsService::class => Odds\Service\OddsServiceFactory::class,
            PickForWin\Command\PickForWin::class => PickForWin\Command\PickForWinFactory::class,
            PickForWin\Service\PickForWinService::class => PickForWin\Service\PickForWinServiceFactory::class,
            Match\Service\MatchService::class => Match\Service\MatchServiceFactory::class,
            Scrapy\Service\ScrapyService::class => Scrapy\Service\ScrapyServiceFactory::class,
            Team\Service\TeamService::class => Team\Service\TeamServiceFactory::class,
            Tournament\Service\TournamentService::class => Tournament\Service\TournamentServiceFactory::class,
            WhoScored\Command\PreviewOverview::class => WhoScored\Command\PreviewOverviewFactory::class,
            WhoScored\Command\PreviewMatches::class => WhoScored\Command\PreviewMatchesFactory::class,
            WhoScored\Service\WhoScoredPreviewOverviewService::class => WhoScored\Service\WhoScoredPreviewOverviewServiceFactory::class,
            WhoScored\Service\WhoScoredPreviewMatchesService::class => WhoScored\Service\WhoScoredPreviewMatchesServiceFactory::class,
            WhoScoredPreview\Service\WhoScoredPreviewService::class => WhoScoredPreview\Service\WhoScoredPreviewServiceFactory::class
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
                    __DIR__.'/../src/Odds/Entity',
                    __DIR__.'/../src/Match/Entity',
                    __DIR__.'/../src/Result/Entity',
                    __DIR__.'/../src/Scrapy/Entity',
                    __DIR__.'/../src/Team/Entity',
                    __DIR__.'/../src/Tournament/Entity',
                    __DIR__.'/../src/WhoScoredPreview/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'EduBet\Odds' => 'my_annotation_driver',
                    'EduBet\Match' => 'my_annotation_driver',
                    'EduBet\Result' => 'my_annotation_driver',
                    'EduBet\Scrapy' => 'my_annotation_driver',
                    'EduBet\Team' => 'my_annotation_driver',
                    'EduBet\Tournament' => 'my_annotation_driver',
                    'EduBet\WhoScoredPreview' => 'my_annotation_driver',
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
