<?php
namespace EduBet\Controller;

use EduBet\Match\Service\MatchService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /** @var MatchService  */
    protected $matchService;

    /**
     * IndexController constructor.
     * @param MatchService $matchService
     */
    public function __construct(
        MatchService $matchService
    ) {
        $this->matchService = $matchService;
    }

    public function indexAction()
    {
        $matches = $this->matchService->getMatches();

        return new ViewModel(
            [
                'matches' => $matches
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

    }
}
