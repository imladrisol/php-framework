<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\YoutubeService;
use Framework\Controller\AbstractController;
use Framework\Http\Response;

final class HomeController extends AbstractController
{
    private YoutubeService $youtubeService;

    public function __construct(
        YoutubeService $youtubeService
    ) {
        $this->youtubeService = $youtubeService;
    }

    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'youtube' => $this->youtubeService->getChannelUrl(),
        ]);
    }
}
