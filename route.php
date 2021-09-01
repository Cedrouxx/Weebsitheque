<?php

use App\Controller\DefaultController;
use App\Controller\AuthController;
use App\Controller\AnimeController;
use App\Controller\MangaController;
use App\Controller\AdminController;

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

    // Admin
    '/admin' => [ 'class' => AdminController::class, 'method' => 'index' ],
        // add
    '/admin/add/artwork' => [ 'class' => AdminController::class, 'method' => 'addArtwork' ],
];