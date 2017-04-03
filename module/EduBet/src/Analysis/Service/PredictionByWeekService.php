<?php
namespace EduBet\Analysis\Service;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Analysis\Entity\ProfitByWeek;
use EduBet\Analysis\Strategy\StrategyInterface;
use EduBet\Match\Entity\Match;
use EduBet\Match\Service\MatchService;

class PredictionByWeekService
{
    /** @var array  */
    protected $strategies;

    /** @var MatchService  */
    protected $matchService;

    /** @var Match[]  */
    protected $matches;

    /**
     * PredictionByWeekService constructor.
     * @param StrategyInterface[]|array $strategies
     * @param MatchService $matchService
     */
    public function __construct(
        array $strategies,
        MatchService $matchService
    ) {
        $this->strategies = $strategies;
        $this->matchService = $matchService;

        $this->matches = $matchService->getResults();
    }

    /**
     * @return PredictionByWeek
     */
    public function getPredictionsByWeek()
    {
        $predictionByWeek = new PredictionByWeek();
        foreach ($this->strategies as $strategy) {
            $predictionByWeek  = $strategy->predictionByWeek($this->matches, $predictionByWeek);
        }

        return $predictionByWeek;
    }

    /**
     * @return ProfitByWeek
     */
    public function getProfitByWeek()
    {
        $profitByWeek = new ProfitByWeek();
        foreach ($this->strategies as $strategy) {
            $profitByWeek  = $strategy->profitByWeek($this->matches, $profitByWeek);
        }

        return $profitByWeek;
    }
}