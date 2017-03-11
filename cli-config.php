<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

include __DIR__ . '/vendor/autoload.php';

$application = Zend\Mvc\Application::init(require __DIR__ . '/config/application.config.php');
$services    = $application->getServiceManager();

/** @var \Doctrine\ORM\EntityManager $em */
$em = $services->get('doctrine.entitymanager.orm_default');

return ConsoleRunner::createHelperSet($em);
