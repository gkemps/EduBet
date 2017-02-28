<?php
namespace EduBet\Match\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EduBet\Match\Entity\Match;
use EduBet\Match\Exception\MatchAlreadyExistsException;
use EduBet\Team\Entity\Team;
use EduBet\Tournament\Entity\Tournament;

class MatchService
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
     * @return mixed
     */
    public function getWhoScoredMatch(int $whoScoredId)
    {
        return $this->getRepository()->findOneBy(
            [
                'whoScoredId' => $whoScoredId
            ]
        );
    }

    /**
     * @return array|Match[]
     */
    public function getMatches()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Tournament $tournament
     * @param Team $homeTeam
     * @param Team $awayTeam
     * @param DateTime $timestamp
     * @param int $whoScoredId
     * @return Match
     * @throws MatchAlreadyExistsException
     */
    public function createNewMatch(
        Tournament $tournament,
        Team $homeTeam,
        Team $awayTeam,
        DateTime $timestamp,
        int $whoScoredId = null
    ) {
        /** @var Match $match */
        $match = $this->getRepository()->findOneBy(
            [
                'homeTeam' => $homeTeam->getId(),
                'timestamp' => $timestamp->getTimestamp()
            ]
        );

        if (!is_null($match)) {
            throw new MatchAlreadyExistsException("Match already exists: ".$match->toString());
        }

        $match = new Match();
        $match->setTournament($tournament);
        $match->setHomeTeam($homeTeam);
        $match->setAwayTeam($awayTeam);
        $match->setTimestamp($timestamp->getTimestamp());
        $match->setWhoScoredId($whoScoredId);

        $this->persist($match);
        $this->log($match->toString());

        return $match;
    }

    /**
     * @param Match $match
     */
    protected function persist(Match $match)
    {
        $this->em->persist($match);
        $this->em->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository("EduBet\Match\Entity\Match");
    }

    /**
     * @param string $message
     */
    protected function log(string $message)
    {
        print $message . "\r\n";
    }
}