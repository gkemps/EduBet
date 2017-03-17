<?php
namespace EduBet\BetFair\Command;

use EduBet\Betfair\Service\BetfairService;

class BetfairOdds
{
    /** @var BetfairService  */
    protected $betfairService;

    /**
     * BetfairOdds constructor.
     * @param BetfairService $betfairService
     */
    public function __construct(
        BetfairService $betfairService
    ) {
        $this->betfairService = $betfairService;
    }

    function __invoke()
    {
        $this->betfairService->processOdds();
    }
}