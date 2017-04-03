<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Analysis\Entity\ProfitByWeek;
use EduBet\Match\Entity\Match;

abstract class DefaultStrategy implements StrategyInterface
{
    const SOURCE = "Default";
    const LABEL = "Default";

    /**
     * @return string
     */
    public function getLabel() : string
    {
        return static::LABEL;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return static::SOURCE;
    }

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
            $successFul = $this->successful($match);
            if (is_null($successFul)) {
                continue;
            }

            $weekNumber = $match->getDateTime()->format('W');

            if ($successFul) {
                $predictionByWeek->addCorrectMatch(static::SOURCE, $weekNumber);
            } else {
                $predictionByWeek->addIncorrectMatch(static::SOURCE, $weekNumber);
            }
        }

        return $predictionByWeek;
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
                $profitByWeek->addCorrectMatch(static::SOURCE, $weekNumber, $match->getExpectedProfit());
            } else {
                $profitByWeek->addIncorrectMatch(static::SOURCE, $weekNumber);
            }
        }

        return $profitByWeek;
    }
}