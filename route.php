<?php

use App\Controller\DefaultController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\DiverController;
use App\Controller\ArtworkController;
use App\Controller\ApiController;

return [
    // Default
    '/' => [ 'class' => DefaultController::class, 'method' => 'home' ],

    // Auths
        // login
    '/login' => [ 'class' => AuthController::class, 'method' => 'login' ],
    '/loginPost' => [ 'class' => AuthController::class, 'method' => 'loginPost' ],

        // register
    '/register' => [ 'class' => AuthController::class, 'method' => 'register' ],
    '/registerPost' => [ 'class' => AuthController::class, 'method' => 'registerPost' ],

        // logout
    '/logout' => [ 'class' => AuthController::class, 'method' => 'logout' ],

    // User Account
    '/my-account' => [ 'class' => AuthController::class, 'method' => 'myAccount' ],
    '/my-account/change-username' => [ 'class' => AuthController::class, 'method' => 'changeUsername' ],
    '/my-account/change-email' => [ 'class' => AuthController::class, 'method' => 'changeEmail' ],
    '/my-account/change-password' => [ 'class' => AuthController::class, 'method' => 'changePassword' ],

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

    // API
    '/api/UserList/ChangeStatus' => [ 'class' => ApiController::class, 'method' => 'UserListChangeStatus' ],
    '/api/UserList/RemoveArtworkList' => [ 'class' => ApiController::class, 'method' => 'RemoveArtworkList' ],
    '/api/UserList/AddArtworkList' => [ 'class' => ApiController::class, 'method' => 'AddArtworkList' ],
        // get user list
    '/api/UserList/getUserList/all' => [ 'class' => ApiController::class, 'method' => 'getUserList', 'parameter' => ['all'] ],
    '/api/UserList/getUserList/anime' => [ 'class' => ApiController::class, 'method' => 'getUserList', 'parameter' => ['anime'] ],
    '/api/UserList/getUserList/manga' => [ 'class' => ApiController::class, 'method' => 'getUserList', 'parameter' => ['manga'] ],

];