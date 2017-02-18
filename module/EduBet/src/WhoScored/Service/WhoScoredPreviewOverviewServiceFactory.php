<?php
namespace EduBet\WhoScored\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class WhoScoredPreviewOverviewServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new WhoScoredPreviewOverviewService();
    }
}