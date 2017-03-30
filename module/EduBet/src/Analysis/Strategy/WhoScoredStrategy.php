<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Match\Entity\Match;

class WhoScoredStrategy implements StrategyInterface
{
    const SOURCE = "WhoScored";

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
            if (null == $match->getResult() || null == $match->getWhoScoredPreview()) {
                continue;
            }

            $weekNumber = $match->getDateTime()->format('W');

            $correct = $match->getResult()->getToto() == $match->getWhoScoredPreview()->getToto();
            if ($correct) {
                $predictionByWeek->addCorrectMatch(self::SOURCE, $weekNumber);
            } else {
                $predictionByWeek->addIncorrectMatch(self::SOURCE, $weekNumber);
            }
        }

        return $predictionByWeek;
    }
}