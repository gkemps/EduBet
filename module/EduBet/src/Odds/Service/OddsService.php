<?php
namespace EduBet\Odds\Service;

use Doctrine\ORM\EntityManagerInterface;
use EduBet\Odds\Entity\Odds;

class OddsService
{
    /** @var EntityManagerInterface */
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
     * @param Odds $odds
     * @return Odds
     */
    public function createNewOdds(Odds $odds)
    {
        $this->persist($odds);

        return $odds;
    }

    /**
     * @param Odds $odds
     */
    protected function persist(Odds $odds)
    {
        $this->em->persist($odds);
        $this->em->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository("EduBet\Odds\Entity\Odds");
    }
}