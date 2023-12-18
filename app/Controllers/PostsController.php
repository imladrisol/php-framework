<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Controller\AbstractController;
use Framework\Http\Response;

final class PostsController extends AbstractController
{
    public function show(int $id): Response
    {
        return $this->render('posts.html.twig', [
            'postId' => $id,
        ]);
    }
}
