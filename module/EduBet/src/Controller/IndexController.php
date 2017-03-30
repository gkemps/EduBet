<?php
namespace EduBet\Controller;

use EduBet\Analysis\Service\PredictionByWeekService;
use EduBet\Match\Service\MatchService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /** @var MatchService  */
    protected $matchService;

    /** @var PredictionByWeekService  */
    protected $predictionByWeekService;

    /**
     * IndexController constructor.
     * @param MatchService $matchService
     * @param PredictionByWeekService $predictionByWeekService
     */
    public function __construct(
        MatchService $matchService,
        PredictionByWeekService $predictionByWeekService
    ) {
        $this->matchService = $matchService;
        $this->predictionByWeekService = $predictionByWeekService;
    }

    public function indexAction()
    {
        $predictionByWeek = $this->predictionByWeekService->getPredictionsByWeek();

        return new ViewModel(
            [
                'predictionByWeek' => $predictionByWeek
            ]
        );
    }

    public function fixturesAction()
    {
        $matches = $this->matchService->getFixtures();

        return new ViewModel(
            [
                'matches' => $matches
            ]
        );
    }

    public function resultsAction()
    {
        $matches = $this->matchService->getResults(strtotime("1 week ago"));

        return new ViewModel(
            [
                'matches' => $matches
            ]
        );
    }
}
