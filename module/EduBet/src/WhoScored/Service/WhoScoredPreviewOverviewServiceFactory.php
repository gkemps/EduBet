<?php
namespace EduBet\WhoScored\Service;

use EduBet\Monolog\Logger;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WhoScoredPreviewOverviewServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \EduBet\Team\Service\TeamService $teamService */
        $teamService = $container->get("EduBet\Team\Service\TeamService");

        /** @var \EduBet\Tournament\Service\TournamentService $tournamentService */
        $tournamentService = $container->get("EduBet\Tournament\Service\TournamentService");

        /** @var \EduBet\Match\Service\MatchService $matchService */
        $matchService = $container->get("EduBet\Match\Service\MatchService");

        /** @var \EduBet\Scrapy\Service\ScrapyService $scrapyService */
        $scrapyService = $container->get("EduBet\Scrapy\Service\ScrapyService");

        /** @var Logger $logger */
        $logger = $container->get(Logger::class);

        return new WhoScoredPreviewOverviewService(
            $teamService,
            $tournamentService,
            $matchService,
            $scrapyService,
            $logger
        );
    }
}