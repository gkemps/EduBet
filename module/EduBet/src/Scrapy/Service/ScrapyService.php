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
     * @param string|null $matchUrl
     * @return bool|Scrapy
     */
    public function createScrapy(Match $match, string $matchUrl = null)
    {
        if (null == $match->getWhoScoredId()) {
            return false;
        }
        if (is_null($matchUrl)) {
            $matchUrl = sprintf("/Matches/%s/Preview/", $match->getWhoScoredId());
        }

        $scrapy = new Scrapy();
        $scrapy->setMatchId($match->getWhoScoredId());
        $scrapy->setUrl($matchUrl);

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