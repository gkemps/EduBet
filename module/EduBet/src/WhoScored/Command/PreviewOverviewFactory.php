<?php
namespace EduBet\WhoScored\Command;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WhoScoredFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $whoScoredPreviewOverviewService = $container->get("EduBet\WhoScored\Service\WhoScoredPreviewOverviewService");

        return new WhoScored(
            $whoScoredPreviewOverviewService
        );
    }
}