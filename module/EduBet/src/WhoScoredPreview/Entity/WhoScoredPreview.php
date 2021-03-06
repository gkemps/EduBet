<?php
namespace EduBet\WhoScoredPreview\Entity;

use Doctrine\ORM\Mapping as ORM;
use EduBet\Match\Entity\Match;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_whoscoredPreview")
 */
class WhoScoredPreview
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $homeScore;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $awayScore;

    /**
     * @ORM\OneToOne(targetEntity="EduBet\Match\Entity\Match")
     * @ORM\JoinColumn(name="edubet_match_id", referencedColumnName="id")
     *
     * @var Match
     **/
    protected $match;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function toString()
    {
        return $this->homeScore." - ".$this->awayScore;
    }

    /**
     * @return int|null
     */
    public function getToto()
    {
        if (is_null($this->homeScore)) {
            return null;
        }

        if ($this->homeScore > $this->awayScore) {
            return 1;
        } elseif ($this->awayScore > $this->homeScore) {
            return 2;
        } else {
            return 3;
        }
    }

    /**
     * @return number
     */
    public function getGoalDifference()
    {
        return abs($this->homeScore - $this->awayScore);
    }
}