<?php
namespace EduBet\WhoScored\Service;

use DateTime;
use DOMDocument;
use DOMElement;
use DOMXPath;
use EduBet\Match\Exception\MatchAlreadyExistsException;
use EduBet\Match\Service\MatchService;
use EduBet\Scrapy\Service\ScrapyService;
use EduBet\Team\Service\TeamService;
use EduBet\Tournament\Entity\Tournament;
use EduBet\Tournament\Service\TournamentService;
use Psr\Log\LoggerInterface;

class WhoScoredPreviewOverviewService
{
    /** @var TeamService  */
    protected $teamService;

    /** @var TournamentService  */
    protected $tournamentService;

    /** @var MatchService  */
    protected $matchService;

    /** @var ScrapyService  */
    protected $scrapyService;

    /** @var  LoggerInterface */
    protected $logger;

    /**
     * WhoScoredPreviewOverviewService constructor.
     * @param TeamService $teamService
     * @param TournamentService $tournamentService
     * @param MatchService $matchService
     * @param ScrapyService $scrapyService
     */
    public function __construct(
        TeamService $teamService,
        TournamentService $tournamentService,
        MatchService $matchService,
        ScrapyService $scrapyService,
        LoggerInterface $logger
    ) {
        $this->teamService = $teamService;
        $this->tournamentService = $tournamentService;
        $this->matchService = $matchService;
        $this->scrapyService = $scrapyService;
        $this->logger = $logger;
    }

    public function extractPreviewMatches(string $html)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $xpath = new DOMXpath($doc);
        $result = $xpath->query("//table");

        /** @var  DOMElement $table */
        $currentDay = "";
        $currentTime = "";
        $tournament = null;
        foreach ($result as $table) {
            /** @var DomElement $tr */
            foreach ($table->firstChild->childNodes as $tr) {
                if (!$tr->hasChildNodes()) {
                    continue;
                }
                /** @var DomElement $td */
                foreach ($tr->childNodes as $td) {
                    if (get_class($td) == "DOMText") {
                        continue;
                    }
                    if ($td->getAttribute('class') == "previews-date") {
                        $currentDay = trim(substr($td->nodeValue, 0, strpos($td->nodeValue, ",")));
                    }
                    if ($td->getAttribute('class') == "time") {
                        $currentTime = trim($td->nodeValue);
                    }
                    $tournament = $this->findTournament($td) ?? $tournament;
                    if (false != stripos($td->nodeValue, " vs ")) {
                        $dateTime = new \DateTime();
                        $dateTime->setTimestamp(strtotime($currentDay." ".$currentTime));

                        list($home, $away) = explode(" vs ", trim($td->nodeValue));
                        $homeTeam = $this->teamService->findOrCreateTeam($home);
                        $awayTeam = $this->teamService->findOrCreateTeam($away);

                        $whoScoredId = $this->extractMatchWhoScoredId($td);

                        $match = $this->matchService->getWhoScoredMatch($whoScoredId);

                        if (!is_null($match)) {
                            $match->setTimestamp($dateTime->getTimestamp());

                            $this->matchService->updateMatch($match);

                            $this->logger->info(
                                "Match ({$match->getId()}) updated: ".$match->toString()
                            );
                            continue;
                        }

                        try {
                            $match = $this->matchService->createNewMatch(
                                $tournament,
                                $homeTeam,
                                $awayTeam,
                                $dateTime,
                                $whoScoredId
                            );
                            $this->logger->info(
                                "Match created: ".$match->toString()
                            );
                            $matchUrl = $this->extractMatchUrl($td);
                            $this->scrapyService->createScrapy($match, $matchUrl);
                        } catch (MatchAlreadyExistsException $e) {
                            $this->logger->error($e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * @param DOMElement $td
     * @return int|null
     */
    protected function extractMatchWhoScoredId(DOMElement $td)
    {
        if ($td->hasChildNodes() && $td->childNodes->length == 3) {
            /** @var DOMElement $node */
            foreach ($td->childNodes as $node) {
                if ($node instanceof DOMElement && $node->tagName == "a" && false != stripos($node->getAttribute('href'), "preview")) {
                    $href = explode("/", $node->getAttribute('href'));
                    $whoScoredId = (int) $href[2];

                    return $whoScoredId;
                }
            }
        }

        return null;
    }

    /**
     * @param DOMElement $td
     * @return null|string
     */
    protected function extractMatchUrl(DOMElement $td)
    {
        if ($td->hasChildNodes() && $td->childNodes->length == 3) {
            /** @var DOMElement $node */
            foreach ($td->childNodes as $node) {
                if ($node instanceof DOMElement && $node->tagName == "a" && false != stripos($node->getAttribute('href'), "preview")) {
                    return $node->getAttribute('href');
                }
            }
        }

        return null;
    }

    /**
     * @param DOMElement $td
     * @return Tournament|null
     */
    protected function findTournament (DOMElement $td)
    {
        if ($td->hasChildNodes() && $td->childNodes->length == 3) {
            /** @var DOMElement $node */
            foreach ($td->childNodes as $node) {
                if ($node instanceof DOMElement && $node->tagName == "a" && false != stripos($node->getAttribute('href'), "tournament")) {
                    $name = trim($node->nodeValue);
                    $href = explode("/", $node->getAttribute('href'));
                    $whoScoredId = (int) $href[4];

                    return $this->tournamentService->findOrCreateWhoScoredTournament($whoScoredId, $name);
                }
            }
        }

        return null;
    }
}