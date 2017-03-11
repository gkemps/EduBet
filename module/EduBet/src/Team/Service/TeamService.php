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
        $team = $this->getRepository()->findOneBy(
            [
                'name' => $name,
            ]
        );

        if (is_null($team)) {
            $team = $this->createNewTeam($name);
        }

        return $team;
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