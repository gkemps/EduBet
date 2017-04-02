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
     * @param int $whoScoredId
     * @return Match
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
        $qb = $this->em->createQueryBuilder();

        $qb->select("m")
            ->from("EduBet\Match\Entity\Match", "m")
            ->orderBy("m.timestamp");

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array|Match[]
     */
    public function getFixtures()
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select("m")
            ->from("EduBet\Match\Entity\Match", "m")
            ->where($qb->expr()->gte("m.timestamp", time()))
            ->orderBy("m.timestamp");

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $start
     * @return array|\EduBet\Match\Entity\Match[]
     */
    public function getResults(
        int $start = null
    ) {
        $qb = $this->em->createQueryBuilder();

        $qb->select("m")
            ->from("EduBet\Match\Entity\Match", "m")
            ->where($qb->expr()->lte("m.timestamp", (int) gmdate('U') - (100 * 60)))
            ->orderBy("m.timestamp", "desc");

        if (!is_null($start)) {
            $qb->andWhere($qb->expr()->gte("m.timestamp", $start));
        }

        return $qb->getQuery()->getResult();
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
        if (!is_null($whoScoredId)) {
            $match = $this->getWhoScoredMatch($whoScoredId);
        } else {
            $match = $this->findMatchByHomeTeam($homeTeam, $timestamp->getTimestamp());
            if (is_null($match)) {
                $match = $this->findMatchByAwayTeam($awayTeam, $timestamp->getTimestamp());
            }
        }

        if (!is_null($match)) {
            throw new MatchAlreadyExistsException("Match already exists: " . $match->toString());
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
     * @return Match
     */
    public function updateMatch(Match $match)
    {
        $this->persist($match);

        return $match;
    }

    /**
     * @param Team $homeTeam
     * @param int $timestamp
     * @return null|Match
     */
    public function findMatchByHomeTeam(
        Team $homeTeam,
        int $timestamp
    ) {
        $qb = $this->em->createQueryBuilder();

        $qb->select("m")
            ->from("EduBet\Match\Entity\Match", "m")
            ->where($qb->expr()->eq("m.homeTeam", $homeTeam->getId()))
            ->andWhere($qb->expr()->gte("m.timestamp", $timestamp - (24 * 3600)))
            ->andWhere($qb->expr()->lte("m.timestamp", $timestamp + (24 * 3600)));

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Team $awayTeam
     * @param int $timestamp
     * @return null|Match
     */
    public function findMatchByAwayTeam(
        Team $awayTeam,
        int $timestamp
    ) {
        $qb = $this->em->createQueryBuilder();

        $qb->select("m")
            ->from("EduBet\Match\Entity\Match", "m")
            ->where($qb->expr()->eq("m.awayTeam", $awayTeam->getId()))
            ->andWhere($qb->expr()->gte("m.timestamp", $timestamp - (24 * 3600)))
            ->andWhere($qb->expr()->lte("m.timestamp", $timestamp + (24 * 3600)));

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $betfairId
     * @return null|Match
     */
    public function findMatchByBetfairId(int $betfairId)
    {
        return $this->getRepository()->findOneBy(
            [
                'betfairId' => $betfairId
            ]
        );
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