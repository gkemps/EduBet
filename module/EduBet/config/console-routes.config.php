<?php

return array(
    array(
        'name' => 'preview-overview',
        'route' => 'preview-overview',
        'description' => 'Analyze the overview page of all WhoScored previews',
        'short_description' => 'Analyse WhoScored previews',
        'options_descriptions' => array(),
        'defaults' => array(),
        'handler' => EduBet\WhoScored\Command\PreviewOverview::class,
    ),
    array(
        'name' => 'preview-matches',
        'route' => 'preview-matches',
        'description' => 'Analyze the detail pages of all crawled matches',
        'short_description' => 'Analyse WhoScored match pages',
        'options_descriptions' => array(),
        'defaults' => array(),
        'handler' => EduBet\WhoScored\Command\PreviewMatches::class,
    ),
    array(
        'name' => 'betfair-odds',
        'route' => 'betfair-odds',
        'description' => 'Analyze Betfair Odds',
        'short_description' => 'Analyze Betfair Odds',
        'options_descriptions' => array(),
        'defaults' => array(),
        'handler' => EduBet\Betfair\Command\BetfairOdds::class,
    ),
);