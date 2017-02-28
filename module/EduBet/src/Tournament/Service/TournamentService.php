<?php
namespace EduBet\Tournament\Service;

use Doctrine\ORM\EntityManagerInterface;
use EduBet\Tournament\Entity\Tournament;

class TournamentService
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
     * @param int $whoScoredId
     * @param string $name
     * @return Tournament
     */
    public function findOrCreateWhoScoredTournament(int $whoScoredId, string $name)
    {
        $tournament = $this->getRepository()->findOneBy(
            [
                'whoScoredId' => $whoScoredId,
            ]
        );

        if (is_null($tournament)) {
            $tournament = $this->createNewTournament($name, $whoScoredId);
        }

        return $tournament;
    }

    /**
     * @param string $name
     * @param int|null $whoScoredId
     * @return Tournament
     */
    public function createNewTournament(string $name, int $whoScoredId = null)
    {
        $tournament = new Tournament();
        $tournament->setName($name);
        $tournament->setWhoScoredId($whoScoredId);

        $this->persist($tournament);

        return $tournament;
    }

    /**
     * @param Tournament $tournament
     */
    protected function persist(Tournament $tournament)
    {
        $this->em->persist($tournament);
        $this->em->flush();
    }

    protected function getRepository()
    {
        return $this->em->getRepository("EduBet\Tournament\Entity\Tournament");
    }
}