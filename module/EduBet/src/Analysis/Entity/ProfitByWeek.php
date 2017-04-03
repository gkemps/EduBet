<?php
namespace EduBet\Analysis\Entity;

class ProfitByWeek
{
    /** @var array */
    protected $profit = [];

    /**
     * @param string $source
     * @param int $weekNumber
     */
    public function addIncorrectMatch(string $source, int $weekNumber)
    {
        if (!isset($this->profit[$source][$weekNumber])) {
            $this->profit[$source][$weekNumber] = 0;
        }

        $this->profit[$source][$weekNumber] -= 1;
    }

    /**
     * @param string $source
     * @param int $weekNumber
     * @param float $profit
     */
    public function addCorrectMatch(string $source, int $weekNumber, float $profit)
    {
        if (!isset($this->profit[$source][$weekNumber])) {
            $this->profit[$source][$weekNumber] = 0;
        }

        $this->profit[$source][$weekNumber] += $profit;
    }

    /**
     * @return array
     */
    public function getWeeks()
    {
        $weeks = [];
        foreach ($this->profit as $source => $predictions) {
            foreach ($predictions as $week => $prediction) {
                $weeks[] = $week;
            }
        }

        $weeks = array_unique($weeks);
        sort($weeks);

        return $weeks;
    }

    /**
     * @return array
     */
    public function getSources()
    {
        return array_keys($this->profit);
    }

    /**
     * @param string $source
     * @param int $weekNumber
     * @return float|null
     */
    public function getProfit(string $source, int $weekNumber)
    {
        if (!isset($this->profit[$source][$weekNumber])) {
            return null;
        }

        return $this->profit[$source][$weekNumber];
    }
}