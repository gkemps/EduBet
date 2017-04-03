<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class PickForWinPicksStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "PickForWin (Picks)";
    const LABEL = "P4W+";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        return !is_null($match->getPickForWin()) && !is_null($match->getPickForWin()->getPick());
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

        return $match->getResult()->getToto() == $match->getPickForWin()->getPick();
    }
}