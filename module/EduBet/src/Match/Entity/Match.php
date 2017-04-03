<?php
namespace EduBet\Match\Entity;

use DateTime;
use EduBet\Odds\Entity\Odds;
use EduBet\PickForWin\Entity\PickForWin;
use EduBet\Result\Entity\Result;
use EduBet\Team\Entity\Team;
use EduBet\Tournament\Entity\Tournament;
use Doctrine\ORM\Mapping as ORM;
use EduBet\WhoScoredPreview\Entity\WhoScoredPreview;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_match")
 */
class Match
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
     * @ORM\ManyToOne(targetEntity="EduBet\Tournament\Entity\Tournament")
     * @ORM\JoinColumn(name="edubet_tournament_id", referencedColumnName="id")
     *
     * @var Tournament
     **/
    protected $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="EduBet\Team\Entity\Team")
     * @ORM\JoinColumn(name="edubet_team_id1", referencedColumnName="id")
     *
     * @var Team
     **/
    protected $homeTeam;

    /**
     * @ORM\ManyToOne(targetEntity="EduBet\Team\Entity\Team")
     * @ORM\JoinColumn(name="edubet_team_id2", referencedColumnName="id")
     *
     * @var Team
     **/
    protected $awayTeam;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $whoScoredId;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $betfairId;

    /**
     * @ORM\OneToOne(targetEntity="EduBet\WhoScoredPreview\Entity\WhoScoredPreview", mappedBy="match")
     *
     * @var WhoScoredPreview
     */
    protected $whoScoredPreview;

    /**
     * @ORM\OneToOne(targetEntity="EduBet\Odds\Entity\Odds", mappedBy="match", cascade={"persist"})
     *
     * @var Odds
     */
    protected $odds;

    /**
     * @ORM\OneToOne(targetEntity="EduBet\PickForWin\Entity\PickForWin", mappedBy="match", cascade={"persist"})
     *
     * @var PickForWin
     */
    protected $pickForWin;

    /**
     * @ORM\OneToOne(targetEntity="EduBet\Result\Entity\Result", mappedBy="match", cascade={"persist"})
     *
     * @var Result
     */
    protected $result;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return Team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * @param Team $homeTeam
     */
    public function setHomeTeam($homeTeam)
    {
        $this->homeTeam = $homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * @param Team $awayTeam
     */
    public function setAwayTeam($awayTeam)
    {
        $this->awayTeam = $awayTeam;
    }

    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($this->timestamp);

        return $dateTime;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getWhoScoredId()
    {
        return $this->whoScoredId;
    }

    /**
     * @param int $whoScoredId
     */
    public function setWhoScoredId($whoScoredId)
    {
        $this->whoScoredId = $whoScoredId;
    }

    /**
     * @return int
     */
    public function getBetfairId()
    {
        return $this->betfairId;
    }

    /**
     * @param int $betfairId
     */
    public function setBetfairId($betfairId)
    {
        $this->betfairId = $betfairId;
    }

    /**
     * @return WhoScoredPreview
     */
    public function getWhoScoredPreview()
    {
        return $this->whoScoredPreview;
    }

    /**
     * @param mixed $whoScoredPreview
     */
    public function setWhoScoredPreview($whoScoredPreview)
    {
        $this->whoScoredPreview = $whoScoredPreview;
    }

    /**
     * @return Odds
     */
    public function getOdds()
    {
        return $this->odds;
    }

    /**
     * @param Odds $odds
     */
    public function setOdds($odds)
    {
        $odds->setMatch($this);

        $this->odds = $odds;
    }

    /**
     * @return PickForWin
     */
    public function getPickForWin()
    {
        return $this->pickForWin;
    }

    /**
     * @param PickForWin $pickForWin
     */
    public function setPickForWin($pickForWin)
    {
        $pickForWin->setMatch($this);

        $this->pickForWin = $pickForWin;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param Result $result
     */
    public function setResult($result)
    {
        $result->setMatch($this);

        $this->result = $result;
    }

    /**
     * @return float|int|null
     */
    public function getExpectedProfit()
    {
        if (is_null($this->result) || is_null($this->odds)) {
            return null;
        }

        if ($this->getOdds()->getToto() == $this->getResult()->getToto()) {
            if ($this->getResult()->getToto() == 1) {
                return $this->getOdds()->getHome() - 1;
            } elseif ($this->getResult()->getToto() == 2) {
                return $this->getOdds()->getAway() - 1;
            } else {
                return $this->getOdds()->getDraw() - 1;
            }
        }

        return -1;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getDateTime()->format('c').": ".
            $this->homeTeam->getName()." vs ".$this->awayTeam->getName().
            " (".$this->tournament->getName().")";
    }
}