<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class FixtureRowClass extends AbstractHelper
{
    function __invoke(Match $match)
    {
        if (is_null($match->getWhoScoredPreview())
            || is_null($match->getOdds())
            || is_null($match->getPickForWin())) {
            return null;
        }

        if ($match->getWhoScoredPreview()->getToto() == $match->getOdds()->getToto()
            && $match->getWhoScoredPreview()->getToto() == $match->getPickForWin()->getToto()) {
            return "success";
        }

        return null;
    }
}