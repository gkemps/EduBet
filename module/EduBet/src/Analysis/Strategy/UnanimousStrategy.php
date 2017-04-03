<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class UnanimousStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "Unanimous";

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

        return $match->getOdds()->getToto() == $match->getWhoScoredPreview()->getToto()
        && $match->getWhoScoredPreview()->getToto() == $match->getPickForWin()->getToto();
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

        return $match->getResult()->getToto() == $match->getOdds()->getToto();
    }
}