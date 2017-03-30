<?php
namespace EduBet\Analysis\Service;

use EduBet\Analysis\Entity\PredictionByWeek;
use EduBet\Analysis\Strategy\StrategyInterface;
use EduBet\Match\Service\MatchService;

class PredictionByWeekService
{
    /** @var array  */
    protected $strategies;

    /** @var MatchService  */
    protected $matchService;

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
    }

    /**
     * @return PredictionByWeek
     */
    public function getPredictionsByWeek()
    {
        $matches = $this->matchService->getResults();

        $predictionByWeek = new PredictionByWeek();
        foreach ($this->strategies as $strategy) {
            $predictionByWeek  = $strategy->predictionByWeek($matches, $predictionByWeek);
        }

        return $predictionByWeek;
    }
}