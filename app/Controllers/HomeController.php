<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Http\Response;

final class HomeController
{
    public function index(): Response
    {
        $content = '<h1>Hello, World</h1>';

        return new Response($content);
    }
}
