<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class PickForWinPicksClass extends AbstractHelper
{
    function __invoke(Match $match)
    {
        if (is_null($match->getPickForWin())
            || is_null($match->getPickForWin()->getPick())
            || is_null($match->getResult())) {
            return null;
        }

        if ($match->getPickForWin()->getPick() == $match->getResult()->getToto()) {
            return "success";
        } else {
            return "danger";
        }
    }
}