<?php
use Zend\Console\Console;
use ZF\Console\Application;
use ZF\Console\Dispatcher;

include __DIR__ . '/../vendor/autoload.php';

define('VERSION', '1.1.3');

$config = include __DIR__ . '/../module/EduBet/config/module.config.php';

$serviceManager = new \Zend\ServiceManager\ServiceManager(
    $config['service_manager']
);

$application = new Application(
    'Builder',
    VERSION,
    include __DIR__ . '/../module/EduBet/config/console-routes.config.php',
    Console::getInstance(),
    new Dispatcher($serviceManager)
);

$exit = $application->run();
exit($exit);