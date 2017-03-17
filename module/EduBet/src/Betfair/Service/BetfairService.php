<?php
namespace EduBet\Betfair\Service;

use EduBet\Match\Entity\Match;
use EduBet\Match\Service\MatchService;
use EduBet\Odds\Entity\Odds;
use EduBet\Odds\Service\OddsService;
use EduBet\Team\Service\TeamService;
use EduBet\Tournament\Service\TournamentService;
use stdClass;
use Zend\Http\Client;

class BetfairService
{
    /** @var Client  */
    protected $client;

    /** @var  string */
    protected $appKey;

    /** @var  string */
    protected $username;

    /** @var  string */
    protected $password;

    /** @var TournamentService  */
    protected $tournamentService;

    /** @var MatchService  */
    protected $matchService;

    /** @var TeamService  */
    protected $teamService;

    /** @var OddsService  */
    protected $oddsService;

    /**
     * BetfairService constructor.
     * @param Client $client
     * @param string $appKey
     * @param string $username
     * @param string $password
     * @param TournamentService $tournamentService
     * @param MatchService $matchService
     * @param TeamService $teamService
     * @param OddsService $oddsService
     */
    public function __construct(
        Client $client,
        string $appKey,
        string $username,
        string $password,
        TournamentService $tournamentService,
        MatchService $matchService,
        TeamService $teamService,
        OddsService $oddsService
    ) {
        $this->client = $client;
        $this->appKey = $appKey;
        $this->username = $username;
        $this->password = $password;
        $this->tournamentService = $tournamentService;
        $this->matchService = $matchService;
        $this->teamService = $teamService;
        $this->oddsService = $oddsService;
    }

    public function processOdds()
    {
        $accessToken = $this->login();
        if (false == $accessToken) {
            die('invalid login');
        }

        $tournaments = $this->tournamentService->getTournaments();
        foreach ($tournaments as $tournament) {
            if (null == $tournament->getBetfairId()) {
                continue;
            }
            $betfairCompetitionId = $tournament->getBetfairId();

            $markets = $this->getNextCompetitionMarketIds(
                $betfairCompetitionId,
                $accessToken
            );
            foreach ($markets as $market) {
                $match = $this->findMatch($market);
                if (is_null($match)) {
                    continue;
                }

                $odds = $this->getMarketOdds($market, $accessToken, $match->getOdds());

                $match->setBetfairId($market->event->id);
                $match->setOdds($odds);

                $this->matchService->updateMatch($match);

                print $match->toString();
                print " ";
                print $odds->toString();
                print "\r\n";
            }
        }
    }

    /**
     * @param stdClass $market
     * @param string $accessToken
     * @param Odds|null $odds
     * @return bool|Odds
     */
    protected function getMarketOdds(
        stdClass $market,
        string $accessToken,
        Odds $odds = null
    ) {
        $this->client->setUri("https://api.betfair.com/exchange/betting/rest/v1/listMarketBook/");
        $this->client->setMethod("POST");
        $this->client->setHeaders(
            [
                'X-Application' => $this->appKey,
                'X-Authentication' => $accessToken,
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ]
        );
        $filters = '
            {"marketIds":["' . $market->marketId . '"], '.
            '"priceProjection":{"priceData":["EX_BEST_OFFERS"]}}
            ';

        $this->client->setRawBody(
            $filters
        );

        $result = $this->client->send();

        if ($result->isOk()) {
            $body = $result->getBody();

            $marketBooks = json_decode($body);

            foreach ($marketBooks as $marketBook) {
                $matchOdds = isset($odds) ? $odds : new Odds();
                foreach ($marketBook->runners as $id => $runner) {
                    if ($id == 0) {
                        $matchOdds->setHome($runner->ex->availableToBack[$id]->price);
                    } elseif ($id == 1) {
                        $matchOdds->setAway($runner->ex->availableToBack[$id]->price);
                    } else {
                        $matchOdds->setDraw($runner->ex->availableToBack[$id]->price);
                    }
                }
                return $matchOdds;
            }
        }

        return false;
    }

    /**
     * @param $market
     * @return null|Match
     */
    protected function findMatch($market)
    {
        if (!isset($market->event)) {
            return null;
        }

        $match = $market->event->name;
        list ($home, $away) = explode(" v ", $match);
        $timestamp = strtotime($market->event->openDate);

        $match = $this->findBetfairMatch(
            $market->event->id,
            $home,
            $away,
            $timestamp
        );

        return $match;
    }

    /**
     * @param int $eventId
     * @param string $home
     * @param string $away
     * @param int $timestamp
     * @return Match|null
     */
    protected function findBetfairMatch(
        int $eventId,
        string $home,
        string $away,
        int $timestamp
    ) {
        $match = $this->matchService->findMatchByBetfairId($eventId);
        if (!is_null($match)) {
            return $match;
        }

        $homeTeam = $this->teamService->findTeam($home);
        if (!is_null($homeTeam)) {
            return $this->matchService->findMatchByHomeTeam($homeTeam, $timestamp);
        }

        $awayTeam = $this->teamService->findTeam($away);
        if (!is_null($awayTeam)) {
            return $this->matchService->findMatchByAwayTeam($awayTeam, $timestamp);
        }

        return null;
    }

    /**
     * @param int $competitionId
     * @param string $accessToken
     * @return bool|mixed
     */
    protected function getNextCompetitionMarketIds(int $competitionId, string $accessToken)
    {
        $this->client->setUri("https://api.betfair.com/exchange/betting/rest/v1/listMarketCatalogue/");
        $this->client->setMethod("POST");
        $this->client->setHeaders(
            [
                'X-Application' => $this->appKey,
                'X-Authentication' => $accessToken,
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            ]
        );
        $filters = '
            {"filter":{"eventTypeIds":["1"],
              "competitionIds":["'.$competitionId.'"],
              "marketTypeCodes":["MATCH_ODDS"],
              "marketStartTime":{"from":"' . date('c') . '"}},
              "sort":"FIRST_TO_START",
              "maxResults":"20",
              "marketProjection":["RUNNER_DESCRIPTION", "EVENT"]}
        ';

        $this->client->setRawBody(
            $filters
        );

        $result = $this->client->send();

        if ($result->isOk()) {
            $body = $result->getBody();

            return json_decode($body);
        }

        return false;
    }

    protected function login()
    {
        $this->client->setUri("https://identitysso.betfair.com/api/login");
        $this->client->setMethod("POST");
        $this->client->setHeaders(
            [
                'X-Application' => $this->appKey,
                'Accept' => 'application/json'
            ]
        );
        $this->client->setParameterPost(
            [
                "username" => $this->username,
                "password" => $this->password
            ]
        );

        $result = $this->client->send();

        if ($result->isOk()) {
            $json = $result->getBody();
            $access = json_decode($json);

            return $access->token;
        }

        return false;
    }
}