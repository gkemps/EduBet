<?php
namespace EduBet\PickForWin\Command;

use EduBet\PickForWin\Service\PickForWinService;

class PickForWin
{
    /** @var  PickForWinService */
    protected $pickForWinService;

    /**
     * PickForWin constructor.
     * @param PickForWinService $pickForWinService
     */
    public function __construct(PickForWinService $pickForWinService)
    {
        $this->pickForWinService = $pickForWinService;
    }

    function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}