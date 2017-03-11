<?php
namespace EduBet\WhoScored\Command;

use EduBet\WhoScored\Service\WhoScoredPreviewMatchesService;

class PreviewMatches
{
    /** @var WhoScoredPreviewMatchesService  */
    protected $whoScoredPreviewMatchesService;

    /**
     * WhoScoredController constructor.
     * @param WhoScoredPreviewMatchesService $whoScoredPreviewMatchesService
     */
    public function __construct(
        WhoScoredPreviewMatchesService $whoScoredPreviewMatchesService
    ) {
        $this->whoScoredPreviewMatchesService = $whoScoredPreviewMatchesService;
    }

    public function __invoke()
    {
        $files = scandir("data/preview/matches");
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $fileName = "data/preview/matches/".$file;
                $html = file_get_contents($fileName);

                $whoScoredPreview = $this->whoScoredPreviewMatchesService->extractMatchInfo(
                    substr($file, 0, strpos($file, ".")),
                    $html
                );

                if (false != $whoScoredPreview) {
                    print $whoScoredPreview->getMatch()->getHomeTeam()->getName();
                    print "(".$whoScoredPreview->getMatch()->getHomeTeam()->getWhoScoredId().")";
                    print " - ";
                    print $whoScoredPreview->getMatch()->getAwayTeam()->getName();
                    print "(".$whoScoredPreview->getMatch()->getAwayTeam()->getWhoScoredId().")";
                    print " ";
                    print $whoScoredPreview->getHomeScore();
                    print " - ";
                    print $whoScoredPreview->getAwayScore();
                    print "\r\n";

                    unlink($fileName);
                }
            }
        }
    }
}