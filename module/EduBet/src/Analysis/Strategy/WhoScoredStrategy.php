<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Match\Entity\Match;

class WhoScoredStrategy extends DefaultStrategy implements StrategyInterface
{
    const SOURCE = "WhoScored";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        return !is_null($match->getWhoScoredPreview());
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

        return $match->getResult()->getToto() == $match->getWhoScoredPreview()->getToto();
    }
}