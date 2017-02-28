<?php
namespace EduBet\Scrapy\Service;

use Doctrine\ORM\EntityManagerInterface;
use EduBet\Match\Entity\Match;
use EduBet\Scrapy\Entity\Scrapy;

class ScrapyService
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
     * @param Match $match
     * @return bool|Scrapy
     */
    public function createScrapy(Match $match)
    {
        if (null == $match->getWhoScoredId()) {
            return false;
        }

        $scrapy = new Scrapy();
        $scrapy->setMatchId($match->getWhoScoredId());

        $this->persist($scrapy);

        return $scrapy;
    }

    /**
     * @param Scrapy $scrapy
     */
    protected function persist(Scrapy $scrapy)
    {
        $this->em->persist($scrapy);
        $this->em->flush();
    }
}