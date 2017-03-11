<?php
namespace EduBet\WhoScoredPreview\Service;

use Doctrine\ORM\EntityManagerInterface;
use EduBet\WhoScoredPreview\Entity\WhoScoredPreview;

class WhoScoredPreviewService
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
     * @param WhoScoredPreview $whoScoredPreview
     * @return WhoScoredPreview
     */
    public function createNewWhoScoredPreview(WhoScoredPreview $whoScoredPreview)
    {
        $this->persist($whoScoredPreview);

        return $whoScoredPreview;
    }

    /**
     * @param WhoScoredPreview $whoScoredPreview
     */
    protected function persist(WhoScoredPreview $whoScoredPreview)
    {
        $this->em->persist($whoScoredPreview);
        $this->em->flush();
    }
}