<?php
namespace EduBet\View\Helper;

use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class FlagClass extends AbstractHelper
{
    function __invoke(Match $match)
    {
        $countryCode = strtolower($match->getTournament()->getCountryCode());

        return "flag-icon flag-icon-".$countryCode;
    }
}