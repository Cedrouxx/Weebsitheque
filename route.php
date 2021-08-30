<?php

use App\Controller\DefaultController;
use App\Controller\AuthController;
use App\Controller\AnimeController;

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
        // lists
    '/anime/search' => [ 'class' => AnimeController::class, 'method' => 'search' ],
];