<?php
use Zend\Console\Console;
use ZF\Console\Application;
use ZF\Console\Dispatcher;

include __DIR__ . '/../vendor/autoload.php';

define('VERSION', '1.1.3');

$application = Zend\Mvc\Application::init(require __DIR__ . '/../config/application.config.php');
$services    = $application->getServiceManager();

$application = new Application(
    'Builder',
    VERSION,
    include __DIR__ . '/../module/EduBet/config/console-routes.config.php',
    Console::getInstance(),
    new Dispatcher($services)
);

$exit = $application->run();
exit($exit);