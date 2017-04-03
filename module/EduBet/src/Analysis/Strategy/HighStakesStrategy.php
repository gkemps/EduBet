<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class HighStakesStrategy extends UnanimousStrategy
{
    const SOURCE = "HighStakes";
    const LABEL = "HS";

    public function applies(Match $match) : bool
    {
        if (null == $match->getOdds()
            || null == $match->getWhoScoredPreview()
            || null == $match->getPickForWin()) {
            return false;
        }

        $unanimous = parent::applies($match);

        return $unanimous
            && $match->getOdds()->getLowestOdds() > 2
            && $match->getWhoScoredPreview()->getGoalDifference() > 1;
    }
}