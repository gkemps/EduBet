<?php
namespace EduBet\Monolog;

use Interop\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $logger = new Logger('EduBet');
        $logger->pushHandler(new StreamHandler('data/logs/edubet.log', Logger::DEBUG));
        $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

        return $logger;
    }
}