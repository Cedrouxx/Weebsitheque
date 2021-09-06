<?php

use App\Controller\DefaultController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\DiverController;
use App\Controller\ArtworkController;

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
    '/anime/search' => [ 'class' => ArtworkController::class, 'method' => 'search', 'parameter' => ['anime'] ],
    '/manga/search' => [ 'class' => ArtworkController::class, 'method' => 'search', 'parameter' => ['manga'] ],
        // info
    '/anime/info' => [ 'class' => ArtworkController::class, 'method' => 'info', 'parameter' => ['anime'] ],
    '/manga/info' => [ 'class' => ArtworkController::class, 'method' => 'info', 'parameter' => ['manga'] ],
        // add comment
    '/anime/addComment' => [ 'class' => ArtworkController::class, 'method' => 'addComment', 'parameter' => ['anime'] ],
    '/manga/addComment' => [ 'class' => ArtworkController::class, 'method' => 'addComment', 'parameter' => ['manga'] ],

    // My List
    '/my-list/all' => [ 'class' => ArtworkController::class, 'method' => 'myList', 'parameter' => ['all'] ],
    '/my-list/anime' => [ 'class' => ArtworkController::class, 'method' => 'myList', 'parameter' => ['anime'] ],
    '/my-list/manga' => [ 'class' => ArtworkController::class, 'method' => 'myList', 'parameter' => ['manga'] ],
        // remove
    '/remove-artwork-list' => [ 'class' => ArtworkController::class, 'method' => 'removeList' ],
        // add
    '/add-artwork-list' => [ 'class' => ArtworkController::class, 'method' => 'addList' ],
        //set status
    '/set-artwork-list-status' => [ 'class' => ArtworkController::class, 'method' => 'setListStatus' ],

    // Divers
        // waifu
    '/diver/waifu' => [ 'class' => DiverController::class, 'method' => 'waifu' ],

    // Admin
    '/admin' => [ 'class' => AdminController::class, 'method' => 'index' ],
        // add
    '/admin/add/artwork' => [ 'class' => AdminController::class, 'method' => 'addArtwork' ],

];