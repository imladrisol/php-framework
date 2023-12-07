<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Http\Response;

final class PostsController
{
    public function show(int $id): Response
    {
        $content = "<h1>Posts - $id</h1>";

        return new Response($content);
    }
}
