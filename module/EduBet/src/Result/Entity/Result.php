<?php
namespace EduBet\Result\Entity;

use EduBet\Match\Entity\Match;

class Result
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Match
     */
    protected $match;

    /**
     * @var int
     */
    protected $homeScore;

    /**
     * @var int
     */
    protected $awayScore;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @param Match $match
     */
    public function setMatch($match)
    {
        $this->match = $match;
    }

    /**
     * @return int
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * @param int $homeScore
     */
    public function setHomeScore($homeScore)
    {
        $this->homeScore = $homeScore;
    }

    /**
     * @return int
     */
    public function getAwayScore()
    {
        return $this->awayScore;
    }

    /**
     * @param int $awayScore
     */
    public function setAwayScore($awayScore)
    {
        $this->awayScore = $awayScore;
    }
}