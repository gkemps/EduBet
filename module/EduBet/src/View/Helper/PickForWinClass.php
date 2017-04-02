<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class PickForWinClass extends AbstractHelper
{
    function __invoke(Match $match, int $toto)
    {
        if (is_null($match->getPickForWin()) || is_null($match->getResult())) {
            return null;
        }

        if ($match->getPickForWin()->getToto() == $toto) {
            if ($match->getPickForWin()->getToto() == $match->getResult()->getToto()) {
                return "success";
            } else {
                return "danger";
            }
        }

        return null;
    }
}