<?php
namespace EduBet\Analysis\Entity;

class PredictionByWeek
{
    /** @var array */
    protected $predictions = [];

    /**
     * @param string $source
     * @param int $weekNumber
     */
    public function addIncorrectMatch(string $source, int $weekNumber)
    {
        if (!isset($this->predictions[$source][$weekNumber])) {
            $this->predictions[$source][$weekNumber]['total'] = 0;
            $this->predictions[$source][$weekNumber]['correct'] = 0;
        }

        $this->predictions[$source][$weekNumber]['total']++;
    }

    /**
     * @param string $source
     * @param int $weekNumber
     */
    public function addCorrectMatch(string $source, int $weekNumber)
    {
        if (!isset($this->predictions[$source][$weekNumber])) {
            $this->predictions[$source][$weekNumber]['total'] = 0;
            $this->predictions[$source][$weekNumber]['correct'] = 0;
        }

        $this->predictions[$source][$weekNumber]['correct']++;
        $this->predictions[$source][$weekNumber]['total']++;
    }

    /**
     * @return array
     */
    public function getWeeks()
    {
        $weeks = [];
        foreach ($this->predictions as $source => $predictions) {
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
        return array_keys($this->predictions);
    }

    /**
     * @param string $source
     * @param int $weekNumber
     * @return float|null
     */
    public function getPrediction(string $source, int $weekNumber)
    {
        if (!isset($this->predictions[$source][$weekNumber])) {
            return null;
        }

        $correct = $this->predictions[$source][$weekNumber]['correct'];
        $total = $this->predictions[$source][$weekNumber]['total'];

        return $correct / $total * 100;
    }
}