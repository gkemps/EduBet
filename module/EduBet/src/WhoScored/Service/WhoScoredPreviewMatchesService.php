<?php
namespace EduBet\WhoScored\Service;

use DOMDocument;
use DOMElement;
use DOMXPath;
use EduBet\Match\Service\MatchService;
use EduBet\Team\Service\TeamService;
use EduBet\WhoScoredPreview\Entity\WhoScoredPreview;
use EduBet\WhoScoredPreview\Service\WhoScoredPreviewService;

class WhoScoredPreviewMatchesService
{
    /** @var TeamService  */
    protected $teamService;

    /** @var MatchService  */
    protected $matchService;

    /** @var WhoScoredPreviewService  */
    protected $whoScoredPreviewService;

    /**
     * WhoScoredPreviewOverviewService constructor.
     * @param TeamService $teamService
     * @param MatchService $matchService
     * @param WhoScoredPreviewService $whoScoredPreviewService
     */
    public function __construct(
        TeamService $teamService,
        MatchService $matchService,
        WhoScoredPreviewService $whoScoredPreviewService
    ) {
        $this->teamService = $teamService;
        $this->matchService = $matchService;
        $this->whoScoredPreviewService = $whoScoredPreviewService;
    }

    /**
     * @param int $whoScoredMatchId
     * @param string $html
     * @return bool|WhoScoredPreview
     */
    public function extractMatchInfo(int $whoScoredMatchId, string $html)
    {
        $match = $this->matchService->getWhoScoredMatch($whoScoredMatchId);
        if (is_null($match)) {
            return false;
        }

        if (null != $match->getWhoScoredPreview()) {
            return false;
        }

        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $xpath = new DOMXpath($doc);

        /** @var DOMElement $homeTeamAnchor */
        $homeTeamAnchor = $xpath->query(
            "//div[@id=\"preview-prediction\"]/div[contains(@class, 'home')]/div[contains(@class, 'team-name')]/a"
        )->item(0);
        /** @var DOMElement $homeScoreSpan */
        $homeScoreSpan = $xpath->query(
            "//div[@id=\"preview-prediction\"]/div[contains(@class, 'home')]/span[contains(@class, 'predicted-score')]"
        )->item(0);
        /** @var DOMElement $awayTeamAnchor */
        $awayTeamAnchor = $xpath->query(
            "//div[@id=\"preview-prediction\"]/div[contains(@class, 'away')]/div[contains(@class, 'team-name')]/a"
        )->item(0);
        /** @var DOMElement $awayScoreSpan */
        $awayScoreSpan = $xpath->query(
            "//div[@id=\"preview-prediction\"]/div[contains(@class, 'away')]/span[contains(@class, 'predicted-score')]"
        )->item(0);

        if ($match->getHomeTeam()->getWhoScoredId() == null) {
            $hrefArray = explode("/", $homeTeamAnchor->getAttribute('href'));
            $whoScoredTeamId = $hrefArray[count($hrefArray) - 1];

            $homeTeam = $match->getHomeTeam();
            $homeTeam->setWhoScoredId($whoScoredTeamId);

            $this->teamService->updateTeam($homeTeam);
        }

        if ($match->getAwayTeam()->getWhoScoredId() == null) {
            $hrefArray = explode("/", $awayTeamAnchor->getAttribute('href'));
            $whoScoredTeamId = $hrefArray[count($hrefArray) - 1];

            $awayTeam = $match->getAwayTeam();
            $awayTeam->setWhoScoredId($whoScoredTeamId);

            $this->teamService->updateTeam($awayTeam);
        }

        $whoScoredPreview = new WhoScoredPreview();
        $whoScoredPreview->setMatch($match);
        $whoScoredPreview->setHomeScore($homeScoreSpan->nodeValue);
        $whoScoredPreview->setAwayScore($awayScoreSpan->nodeValue);

        $this->whoScoredPreviewService->createNewWhoScoredPreview($whoScoredPreview);

        return $whoScoredPreview;
    }
}