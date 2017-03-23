<?php
namespace EduBet\PickForWin\Service;

class PickForWinService
{
    /**
     * PickForWinService constructor.
     */
    public function __construct()
    {
    }

    public function processMatches()
    {
        $html = file_get_contents(
            "http://www.pickforwin.com/en/scientific-sports-predictions.html?sport=football&predictions_date=03/19/2017"
        );

        file_put_contents("data/preview/pickforwin.html", $html);
    }

}