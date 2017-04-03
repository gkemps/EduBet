<?php
return [
    'zfcuser' => [
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'Quiz\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        'enable_username' => true,
        'enable_display_name' => true,
        'enable_registration' => false,
        'login_redirect_route' => 'home'
    ],
];
