<?php
namespace EduBet\Team\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="edubet_teamAlias")
 */
class TeamAlias
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
    protected $alias;

    /**
     * @ORM\ManyToOne(targetEntity="EduBet\Team\Entity\Team")
     * @ORM\JoinColumn(name="edubet_team_id", referencedColumnName="id")
     *
     * @var Team
     **/
    protected $team;
}