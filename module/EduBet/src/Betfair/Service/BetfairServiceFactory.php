<?php
namespace EduBet\Betfair\Service;

use Interop\Container\ContainerInterface;
use Zend\Http\Client;
use Zend\ServiceManager\Factory\FactoryInterface;

class BetfairServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        /** @var \EduBet\Tournament\Service\TournamentService $tournamentService */
        $tournamentService = $container->get("EduBet\Tournament\Service\TournamentService");

        /** @var \EduBet\Match\Service\MatchService $matchService */
        $matchService = $container->get("EduBet\Match\Service\MatchService");

        /** @var \EduBet\Team\Service\TeamService $teamService */
        $teamService = $container->get("EduBet\Team\Service\TeamService");

        /** @var \EduBet\Odds\Service\OddsService $oddsService */
        $oddsService = $container->get("EduBet\Odds\Service\OddsService");

        return new BetfairService(
            new Client(),
            $config['betfair']['appKey'],
            $config['betfair']['username'],
            $config['betfair']['password'],
            $tournamentService,
            $matchService,
            $teamService,
            $oddsService
        );
    }
}