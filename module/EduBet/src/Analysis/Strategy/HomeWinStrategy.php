<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Analysis\Entity\ProfitByWeek;
use EduBet\Match\Entity\Match;

class HomeWinStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "HomeWin";

    public function applies(Match $match) : bool
    {
        return true;
    }

    /**
     * @param Match $match
     * @return bool|null
     */
    public function successful(Match $match)
    {
        if (null == $match->getResult()) {
            return null;
        }

        return $match->getResult()->getToto() == 1;
    }
}