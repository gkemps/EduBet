<?php
namespace EduBet\Controller;

use EduBet\Analysis\Service\PredictionByWeekService;
use EduBet\Match\Service\MatchService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \EduBet\Match\Service\MatchService $matchService */
        $matchService = $container->get(MatchService::class);

        $predictionByWeekService = $container->get(PredictionByWeekService::class);

        return new IndexController(
            $matchService,
            $predictionByWeekService
        );
    }
}