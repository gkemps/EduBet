<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\ProfitByWeek;
use EduBet\Match\Entity\Match;

class LowStakesStrategy extends DefaultStrategy
{
    const SOURCE = "LowStakes";
    const LABEL = "LS";

    /**
     * @param Match $match
     * @return bool
     */
    public function applies(Match $match) : bool
    {
        if (null == $match->getOdds()
            || null == $match->getWhoScoredPreview()
            || null == $match->getPickForWin()) {
            return false;
        }

        return $match->getOdds()->getHighestOdds() > 9.5
            && $match->getWhoScoredPreview()->getGoalDifference() <= 1;
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

        return $match->getResult()->getToto() == $match->getOdds()->getInverseToto();
    }

    /**
     * @param array|Match[] $matches
     * @param ProfitByWeek $profitByWeek
     * @return ProfitByWeek
     */
    public function profitByWeek(
        array $matches,
        ProfitByWeek $profitByWeek
    ) : ProfitByWeek
    {
        foreach ($matches as $match) {
            $successFul = $this->successful($match);
            if (is_null($successFul) || is_null($match->getOdds())) {
                continue;
            }

            $weekNumber = $match->getDateTime()->format('W');
            if ($successFul) {
                $profitByWeek->addCorrectMatch(
                    static::SOURCE,
                    $weekNumber,
                    $match->getTotoProfit(
                        $match->getOdds()->getInverseToto()
                    )
                );
            } else {
                $profitByWeek->addIncorrectMatch(static::SOURCE, $weekNumber);
            }
        }

        return $profitByWeek;
    }
}