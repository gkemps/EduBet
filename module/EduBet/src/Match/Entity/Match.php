<?php
namespace EduBet\Match\Entity;

use DateTime;
use EduBet\Team\Entity\Team;
use EduBet\Tournament\Entity\Tournament;
use Doctrine\ORM\Mapping as ORM;

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
     * @return string
     */
    public function toString()
    {
        return $this->getDateTime()->format('c').": ".
            $this->homeTeam->getName()." vs ".$this->awayTeam->getName().
            " (".$this->tournament->getName().")";
    }
}