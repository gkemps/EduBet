<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Match\Entity\Match;

class PickForWinPicksStrategy implements StrategyInterface
{
    const SOURCE = "PickForWin (Picks)";

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
            if (null == $match->getResult()
                || null == $match->getPickForWin()
                || null == $match->getPickForWin()->getPick()) {
                continue;
            }

            $weekNumber = $match->getDateTime()->format('W');

            $correct = $match->getResult()->getToto() == $match->getPickForWin()->getPick();
            if ($correct) {
                $predictionByWeek->addCorrectMatch(self::SOURCE, $weekNumber);
            } else {
                $predictionByWeek->addIncorrectMatch(self::SOURCE, $weekNumber);
            }
        }

        return $predictionByWeek;
    }
}