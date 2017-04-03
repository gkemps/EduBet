<?php
namespace EduBet\Analysis\Service;

use EduBet\Analysis\Strategy\BetfairStrategy;
use EduBet\Analysis\Strategy\HighStakesStrategy;
use EduBet\Analysis\Strategy\HomeWinStrategy;
use EduBet\Analysis\Strategy\LowStakesStrategy;
use EduBet\Analysis\Strategy\PickForWinPicksStrategy;
use EduBet\Analysis\Strategy\PickForWinStrategy;
use EduBet\Analysis\Strategy\UnanimousStrategy;
use EduBet\Analysis\Strategy\WhoScoredStrategy;
use EduBet\Match\Service\MatchService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PredictionByWeekServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $matchService = $container->get(MatchService::class);

        return new PredictionByWeekService(
            [
                new WhoScoredStrategy(),
                new BetfairStrategy(),
                new PickForWinStrategy(),
                new PickForWinPicksStrategy(),
                new HomeWinStrategy(),
                new UnanimousStrategy(),
                new HighStakesStrategy(),
                new LowStakesStrategy()
            ],
            $matchService
        );
    }
}