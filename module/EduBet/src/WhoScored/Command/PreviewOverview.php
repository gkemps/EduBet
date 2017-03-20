<?php
namespace EduBet\WhoScored\Command;

use EduBet\WhoScored\Service\WhoScoredPreviewOverviewService;
use Exception;

class PreviewOverview
{
    /** @var WhoScoredPreviewOverviewService  */
    protected $whoScoredPreviewOverviewService;

    /**
     * WhoScoredController constructor.
     * @param WhoScoredPreviewOverviewService $whoScoredPreviewOverviewService
     */
    public function __construct(
        WhoScoredPreviewOverviewService $whoScoredPreviewOverviewService
    ) {
        $this->whoScoredPreviewOverviewService = $whoScoredPreviewOverviewService;
    }

    public function __invoke()
    {
        $html = file_get_contents("data/preview/previews.html");

        try {
            $this->whoScoredPreviewOverviewService->extractPreviewMatches($html);
        } catch (Exception $e) {
            die ($e->getMessage());
        }
    }
}