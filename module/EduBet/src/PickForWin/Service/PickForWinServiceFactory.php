<?php
namespace EduBet\PickForWin\Service;

use EduBet\Match\Service\MatchService;
use EduBet\Team\Service\TeamService;
use EduBet\Tournament\Service\TournamentService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PickForWinServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TournamentService $tournamentService */
        $tournamentService = $container->get(TournamentService::class);

        /** @var TeamService $teamService */
        $teamService = $container->get(TeamService::class);

        /** @var MatchService $matchService */
        $matchService = $container->get(MatchService::class);

        return new PickForWinService(
            $tournamentService,
            $teamService,
            $matchService
        );
    }
}