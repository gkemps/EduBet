<?php
namespace EduBet\Tournament\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_tournament")
 */
class Tournament
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
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $whoScoredId;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $betfairId;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $pickForWinId;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $countryCode;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getPickForWinId()
    {
        return $this->pickForWinId;
    }

    /**
     * @param string $pickForWinId
     */
    public function setPickForWinId($pickForWinId)
    {
        $this->pickForWinId = $pickForWinId;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }
}