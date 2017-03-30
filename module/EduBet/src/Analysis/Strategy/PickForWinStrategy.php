<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Match\Entity\Match;

class PickForWinStrategy implements StrategyInterface
{
    const SOURCE = "PickForWin";

    /**
     * @param Match[] $matches
     * @param PredictionByWeek $predictionByWeek
     * @return PredictionByWeek
     */
    public function predictionByWeek(
        array $matches,
        PredictionByWeek $predictionByWeek
    ) : PredictionByWeek {
        foreach ($matches as $match) {
            if (null == $match->getResult() || null == $match->getPickForWin()) {
                continue;
            }

            $weekNumber = $match->getDateTime()->format('W');

            $correct = $match->getResult()->getToto() == $match->getPickForWin()->getToto();
            if ($correct) {
                $predictionByWeek->addCorrectMatch(self::SOURCE, $weekNumber);
            } else {
                $predictionByWeek->addIncorrectMatch(self::SOURCE, $weekNumber);
            }
        }

        return $predictionByWeek;
    }
}