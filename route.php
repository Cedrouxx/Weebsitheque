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
    '/my-account/change/profile-picture' => [ 'class' => AuthController::class, 'method' => 'changeProfilePicture' ],
    '/my-account/change/username' => [ 'class' => AuthController::class, 'method' => 'changeUsername' ],
    '/my-account/change/email' => [ 'class' => AuthController::class, 'method' => 'changeEmail' ],
    '/my-account/change/password' => [ 'class' => AuthController::class, 'method' => 'changePassword' ],

    // Artworks
        // search
    '/:artworkType/search' => [ 'class' => ArtworkController::class, 'method' => 'search' ],

        // info
    '/:artworkType/info/:artworkSlug' => [ 'class' => ArtworkController::class, 'method' => 'info' ],
    
        // add comment
    '/:artworkType/addComment' => [ 'class' => ArtworkController::class, 'method' => 'addComment' ],

    // My List
    '/my-list/:artwork' => [ 'class' => ArtworkController::class, 'method' => 'myList' ],

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
    '/admin/add/author' => [ 'class' => AdminController::class, 'method' => 'addAuthor' ],
    '/admin/add/genre' => [ 'class' => AdminController::class, 'method' => 'addGenre' ],
        // remove
    '/admin/artwork/remove/:artwork_id' => [ 'class' => AdminController::class, 'method' => 'removeArtwork' ],
    '/admin/author/remove/:author_id' => [ 'class' => AdminController::class, 'method' => 'removeAuthor' ],
    '/admin/genre/remove/:genre_id' => [ 'class' => AdminController::class, 'method' => 'removeGenre' ],
        // edit
    '/admin/artwork/edit/:artwork_id' => [ 'class' => AdminController::class, 'method' => 'editArtwork' ],
    '/admin/author/edit/:author_id' => [ 'class' => AdminController::class, 'method' => 'editAuthor' ],
    '/admin/genre/edit/:genre_id' => [ 'class' => AdminController::class, 'method' => 'editGenre' ],
        // editPost
    '/admin/artwork/edit' => [ 'class' => AdminController::class, 'method' => 'editPostArtwork' ],
    '/admin/author/edit' => [ 'class' => AdminController::class, 'method' => 'editPostAuthor' ],
    '/admin/genre/edit' => [ 'class' => AdminController::class, 'method' => 'editPostGenre' ],

    

    // API
        // set user list
    '/api/UserList/ChangeStatus' => [ 'class' => ApiController::class, 'method' => 'UserListChangeStatus' ],
    '/api/UserList/RemoveArtworkList' => [ 'class' => ApiController::class, 'method' => 'RemoveArtworkList' ],
    '/api/UserList/AddArtworkList' => [ 'class' => ApiController::class, 'method' => 'AddArtworkList' ],
        // get user list
    '/api/UserList/getUserList/:artworkType' => [ 'class' => ApiController::class, 'method' => 'getUserList' ],

        // artowrks
    '/api/artwork/:artworkType' => [ 'class' => ApiController::class, 'method' => 'getArtwork' ],

        // status
    '/api/status' => [ 'class' => ApiController::class, 'method' => 'getStatus' ],

];