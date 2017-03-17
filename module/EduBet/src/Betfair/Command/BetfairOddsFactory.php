<?php
namespace EduBet\BetFair\Command;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class BetfairOddsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \EduBet\Betfair\Service\BetfairService $betfairService */
        $betfairService = $container->get('EduBet\Betfair\Service\BetfairService');

        return new BetfairOdds(
            $betfairService
        );
    }
}