<?php
namespace EduBet\Odds\Entity;

use Doctrine\ORM\Mapping as ORM;
use EduBet\Match\Entity\Match;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_odds")
 */
class Odds
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
     * @ORM\Column(type="decimal")
     *
     * @var float
     */
    protected $home;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float
     */
    protected $draw;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float
     */
    protected $away;

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
     * @return float
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * @param float $home
     */
    public function setHome($home)
    {
        $this->home = $home;
    }

    /**
     * @return float
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param float $draw
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;
    }

    /**
     * @return float
     */
    public function getAway()
    {
        return $this->away;
    }

    /**
     * @param float $away
     */
    public function setAway($away)
    {
        $this->away = $away;
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
        return $this->getHome()." / ".$this->getDraw()." / ".$this->getAway();
    }
}