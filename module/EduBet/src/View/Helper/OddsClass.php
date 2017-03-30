<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class OddsClass extends AbstractHelper
{
    function __invoke(Match $match, int $toto)
    {
        if (is_null($match->getOdds())) {
            return null;
        }

        if ($match->getOdds()->getToto() == $toto) {
            if ($match->getOdds()->getToto() == $match->getResult()->getToto()) {
                return "success";
            } else {
                return "danger";
            }
        }

        return null;
    }
}