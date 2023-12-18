<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\YoutubeService;
use Framework\Http\Response;

final class HomeController
{
    private YoutubeService $youtubeService;

    public function __construct(
        YoutubeService $youtubeService
    ) {
        $this->youtubeService = $youtubeService;
    }

    public function index(): Response
    {
        $content = '<h1>Hello, World</h1>';
        $content .= '<a href="' . $this->youtubeService->getChannelUrl() . '">channel</a>';

        return new Response($content);
    }
}
