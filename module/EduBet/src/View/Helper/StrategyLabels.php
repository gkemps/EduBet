<?php
namespace EduBet\View\Helper;

use EduBet\Analysis\Strategy\HighStakesStrategy;
use EduBet\Analysis\Strategy\LowStakesStrategy;
use EduBet\Analysis\Strategy\StrategyInterface;
use EduBet\Analysis\Strategy\UnanimousStrategy;
use EduBet\Match\Entity\Match;
use Zend\View\Helper\AbstractHelper;

class StrategyLabels extends AbstractHelper
{
    function __invoke(Match $match)
    {
        $strategies[] = new UnanimousStrategy();
        $strategies[] = new HighStakesStrategy();
        $strategies[] = new LowStakesStrategy();

        /** @var StrategyInterface $strategy */
        $labels = "";
        foreach ($strategies as $strategy) {
            $success = $strategy->successful($match);
            if (is_null($success)) {
                $label = "label-primary";
            } elseif ($success == false) {
                $label = "label-danger";
            } else {
                $label = "label-success";
            }

            if ($strategy->applies($match)) {
                $labels .= "<span title=\"".$strategy->getName()."\" class=\"label {$label}\">".$strategy->getLabel()."</span>&nbsp;";
            }
        }

        return $labels;
    }
}