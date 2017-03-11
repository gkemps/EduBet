<?php
namespace EduBet\WhoScored\Command;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PreviewMatchesFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $whoScoredPreviewMatchesService = $container->get("EduBet\WhoScored\Service\WhoScoredPreviewMatchesService");

        return new PreviewMatches(
            $whoScoredPreviewMatchesService
        );
    }
}