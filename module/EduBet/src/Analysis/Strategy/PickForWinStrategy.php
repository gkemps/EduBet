<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class PickForWinStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "PickForWin";
    const LABEL = "P4W";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        return !is_null($match->getPickForWin());
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

        return $match->getResult()->getToto() == $match->getPickForWin()->getToto();
    }
}