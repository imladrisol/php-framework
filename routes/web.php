<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\PostsController;
use Framework\Http\Response;
use Framework\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/posts/{id:\d+}', [PostsController::class, 'show']),
    Route::get('/posts/create', [PostsController::class, 'create']),
];
