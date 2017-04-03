<?php
namespace EduBet\Analysis\Strategy;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Analysis\Entity\ProfitByWeek;
use EduBet\Match\Entity\Match;

interface StrategyInterface
{
    public function applies(Match $match) : bool;

    public function successful(Match $match);

    public function predictionByWeek(
        array $matches,
        PredictionByWeek $predictionByWeek
    ) : PredictionByWeek;

    public function profitByWeek(
        array $matches,
        ProfitByWeek $profitByWeek
    ) : ProfitByWeek;
}