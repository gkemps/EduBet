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

                $this->whoScoredPreviewMatchesService->extractMatchInfo(
                    substr($file, 0, strpos($file, ".")),
                    $html
                );

                unlink($fileName);
            }
        }
    }
}