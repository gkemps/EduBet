<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class LowStakesStrategy extends DefaultStrategy
{
    const SOURCE = "LowStakes";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        if (null == $match->getOdds()
            || null == $match->getWhoScoredPreview()
            || null == $match->getPickForWin()) {
            return false;
        }

        return $match->getOdds()->getHighestOdds() > 9.5
            && $match->getWhoScoredPreview()->getGoalDifference() <= 1;
    }

    /**
     * @param Match $match
     * @return bool|null
     */
    public function successful(Match $match)
    {
        if (!$this->applies($match) || is_null($match->getResult())) {
            return null;
        }

        return $match->getResult()->getToto() == $match->getOdds()->getInverseToto();
    }
}