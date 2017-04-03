<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class BetfairStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "Betfair";
    const LABEL = "BF";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        return null != $match->getOdds();
    }

    /**
     * @param Match $match
     * @return bool
     */
    public function successful(Match $match)
    {
        if (!$this->applies($match) || is_null($match->getResult())) {
            return null;
        }

        return $match->getResult()->getToto() == $match->getOdds()->getToto();
    }
}