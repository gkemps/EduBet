<?php
namespace EduBet\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \EduBet\Match\Service\MatchService $matchService */
        $matchService = $container->get("EduBet\Match\Service\MatchService");

        return new IndexController(
            $matchService
        );
    }
}