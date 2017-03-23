<?php
namespace EduBet\Team\Service;

use Doctrine\ORM\EntityManagerInterface;
use EduBet\Team\Entity\Team;

class TeamService
{
    /** @var EntityManagerInterface  */
    protected $em;

    /**
     * TournamentService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @return Team|null|object
     */
    public function findOrCreateTeam(string $name)
    {
        $team = $this->findTeam($name);

        if (is_null($team)) {
            $team = $this->createNewTeam($name);
        }

        return $team;
    }

    /**
     * @param string $name
     * @return null|Team
     */
    public function findTeam(string $name)
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('t')
            ->from("EduBet\Team\Entity\Team", "t")
            ->leftJoin("t.aliases", "a")
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->eq("t.name", $qb->expr()->literal($name)),
                    $qb->expr()->eq("a.alias", $qb->expr()->literal($name))
                )
            );

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $name
     * @param int $whoScoredId
     * @return Team
     */
    public function createNewTeam(string $name, int $whoScoredId = null)
    {
        $team = new Team();
        $team->setName($name);
        $team->setWhoScoredId($whoScoredId);

        $this->persist($team);

        return $team;
    }

    /**
     * @param Team $team
     * @return Team
     */
    public function updateTeam(Team $team)
    {
        $this->persist($team);

        return $team;
    }

    /**
     * @param Team $team
     */
    protected function persist(Team $team)
    {
        $this->em->persist($team);
        $this->em->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository("EduBet\Team\Entity\Team");
    }
}