<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;

interface StrategyInterface
{
    public function predictionByWeek(
        array $matches,
        PredictionByWeek $predictionByWeek
    ) : PredictionByWeek;
}