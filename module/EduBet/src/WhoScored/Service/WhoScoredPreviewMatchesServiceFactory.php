<?php
namespace EduBet\WhoScored\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WhoScoredPreviewMatchesServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \EduBet\Team\Service\TeamService $teamService */
        $teamService = $container->get("EduBet\Team\Service\TeamService");

        /** @var \EduBet\Match\Service\MatchService $matchService */
        $matchService = $container->get("EduBet\Match\Service\MatchService");

        /** @var \EduBet\WhoScoredPreview\Service\WhoScoredPreviewService $whoScoredPreviewService */
        $whoScoredPreviewService = $container->get("EduBet\WhoScoredPreview\Service\WhoScoredPreviewService");

        return new WhoScoredPreviewMatchesService(
            $teamService,
            $matchService,
            $whoScoredPreviewService
        );
    }
}