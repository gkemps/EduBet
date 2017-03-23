<?php
namespace EduBet\PickForWin\Entity;

use Doctrine\ORM\Mapping as ORM;
use EduBet\Match\Entity\Match;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_pickforwin")
 */
class PickForWin
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
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $pick;

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
     * @return int
     */
    public function getPick()
    {
        return $this->pick;
    }

    /**
     * @param int $pick
     */
    public function setPick($pick)
    {
        $this->pick = $pick;
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
}