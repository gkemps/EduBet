<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class WhoScoredClass extends AbstractHelper
{
    function __invoke(Match $match)
    {
        if (is_null($match->getWhoScoredPreview()) || is_null($match->getResult())) {
            return null;
        }

        if ($match->getResult()->getToto() == $match->getWhoScoredPreview()->getToto()) {
            return "success";
        } else {
            return "danger";
        }
    }
}