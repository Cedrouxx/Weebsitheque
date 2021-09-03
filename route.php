<?php

use App\Controller\DefaultController;
use App\Controller\AuthController;
use App\Controller\AnimeController;
use App\Controller\MangaController;
use App\Controller\AdminController;
use App\Controller\DiverController;

return [
    // Default route
    '/' => [ 'class' => DefaultController::class, 'method' => 'home' ],

    // Auths Route
        // login
    '/login' => [ 'class' => AuthController::class, 'method' => 'login' ],
    '/loginPost' => [ 'class' => AuthController::class, 'method' => 'loginPost' ],

        // register
    '/register' => [ 'class' => AuthController::class, 'method' => 'register' ],
    '/registerPost' => [ 'class' => AuthController::class, 'method' => 'registerPost' ],

        // logout
    '/logout' => [ 'class' => AuthController::class, 'method' => 'logout' ],

    // Artworks
        // search
    '/anime/search' => [ 'class' => AnimeController::class, 'method' => 'search' ],
    '/manga/search' => [ 'class' => MangaController::class, 'method' => 'search' ],
        // info
    '/anime/info' => [ 'class' => AnimeController::class, 'method' => 'info' ],
    '/manga/info' => [ 'class' => MangaController::class, 'method' => 'info' ],
        // add comment
    '/anime/addComment' => [ 'class' => AnimeController::class, 'method' => 'addComment' ],
    '/manga/addComment' => [ 'class' => MangaController::class, 'method' => 'addComment' ],

    // Divers
        // waifu
    '/diver/waifu' => [ 'class' => DiverController::class, 'method' => 'waifu' ],

    // Admin
    '/admin' => [ 'class' => AdminController::class, 'method' => 'index' ],
        // add
    '/admin/add/artwork' => [ 'class' => AdminController::class, 'method' => 'addArtwork' ],
];