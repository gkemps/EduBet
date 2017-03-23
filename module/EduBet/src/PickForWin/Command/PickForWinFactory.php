<?php
namespace EduBet\PickForWin\Command;

use EduBet\PickForWin\Service\PickForWinService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PickForWinFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $pickForWinService = $container->get(PickForWinService::class);

        return new PickForWin(
            $pickForWinService
        );
    }
}
