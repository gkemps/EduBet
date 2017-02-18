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
);