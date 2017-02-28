<?php
namespace EduBet\Scrapy\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_scrapy")
 */
class Scrapy
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
     * @var int
     */
    protected $matchId;

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
    public function getMatchId()
    {
        return $this->matchId;
    }

    /**
     * @param int $matchId
     */
    public function setMatchId($matchId)
    {
        $this->matchId = $matchId;
    }
}