<?php
namespace EduBet\PickForWin\Service;

use DateTime;
use DOMDocument;
use DOMElement;
use DOMXPath;
use EduBet\Match\Service\MatchService;
use EduBet\PickForWin\Entity\PickForWin;
use EduBet\Team\Service\TeamService;
use EduBet\Tournament\Service\TournamentService;

class PickForWinService
{
    /** @var TournamentService  */
    protected $tournamentService;

    /** @var TeamService  */
    protected $teamService;

    /** @var MatchService  */
    protected $matchService;

    /**
     * PickForWinService constructor.
     * @param TournamentService $tournamentService
     * @param TeamService $teamService
     * @param MatchService $matchService
     */
    public function __construct(
        TournamentService $tournamentService,
        TeamService $teamService,
        MatchService $matchService
    ) {
        $this->tournamentService = $tournamentService;
        $this->teamService = $teamService;
        $this->matchService = $matchService;
    }

    public function processMatches()
    {
        $date = new DateTime();
        $date->setTimestamp(strtotime("3/25/2017"));

        for ($i = 0; $i < 1; $i++) {
            $today = $date->format('m/d/Y');

            print "Get PickForWin data for day ".$today."\r\n";

            $html = file_get_contents(
                "http://www.pickforwin.com/en/scientific-sports-predictions.html?sport=football&predictions_date=".$today
            );

            $doc = new DOMDocument();
            @$doc->loadHTML($html);

            $xpath = new DOMXpath($doc);
            $result = $xpath->query("//table");

            $processMatches = false;
            /** @var DOMElement $table */
            foreach ($result as $table) {
                //var_dump($table->childNodes->length);
                /** @var DOMElement $childNode */
                foreach ($table->childNodes as $childNode) {
                    if ($childNode->tagName == "tbody") {
                        continue;
                    }
                    if ($childNode->tagName == "th" && false != stristr($childNode->getAttribute("class"), "riganazione")) {
                        $tournamentId = str_replace("&nbsp", "", $childNode->nodeValue);
                        $tournament = $this->tournamentService->getTournamentByPickForWinId($tournamentId);
                        if (!is_null($tournament)) {
                            $processMatches = true;
                            print "Tournament: ".$tournamentId."\r\n";
                            continue;
                        }
                        $processMatches = false;
                    }
                    if ($childNode->tagName == "tr"
                        && (false != stristr($childNode->getAttribute("class"), "rigapari")
                            ||
                            false != stristr($childNode->getAttribute("class"), "rigadispari"))
                        ) {
                        if (!$processMatches) {
                            continue;
                        }

                        $matchInfo = $childNode->childNodes[1]->nodeValue;
                        list($home, $away) = explode(" - ", $matchInfo);

                        $match = null;

                        $homeTeam = $this->teamService->findTeam($home);
                        if (!is_null($homeTeam)) {
                            $match = $this->matchService->findMatchByHomeTeam(
                                $homeTeam,
                                $date->getTimestamp()
                            );
                        }

                        if (is_null($match)) {
                            print "(match not found)\r\n";
                            continue;
                        }

                        $pickForWin = $match->getPickForWin() ?? new PickForWin();

                        $pickForWin->setHome($childNode->childNodes[2]->nodeValue);
                        $pickForWin->setDraw($childNode->childNodes[3]->nodeValue);
                        $pickForWin->setAway($childNode->childNodes[4]->nodeValue);
                        if ($childNode->childNodes[9]->childNodes->length > 0) {
                            /** @var DOMElement $img */
                            $img = $childNode->childNodes[9]->childNodes[0];
                            $pickForWin->setPick(filter_var($img->getAttribute('src'), FILTER_SANITIZE_NUMBER_INT));
                        }

                        $match->setPickForWin($pickForWin);

                        $this->matchService->updateMatch($match);

                        print "Found PickForWin stats for ".$match->toString()."\r\n";
                    }
                }
            }
            $date->add(new \DateInterval("P1D"));
        }
    }
}