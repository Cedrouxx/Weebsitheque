<?php

use App\Controller\ErrorController;

/* redirect to the desired page */
function redirect(string $location = '', bool $withLang = true): void{
    if($withLang)
        header("Location: ".config['baseUrl'].lang['name']."/$location");
    else 
        header("Location: ".config['baseUrl'].'fr'."/$location");
    exit;
}

/* redirect to the last page */
function redirectToLastPage(): void{
    header("Location: {$_SERVER["HTTP_REFERER"]}");
    exit;
}

/* make a error page */
function abord(int $errorCode): void{
    switch ($errorCode){
        case 404:
            $controller = new ErrorController;
            $controller->error404();
            break;
    }
    exit;
}

function route(string $route): string{
    return  $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/'.$route;
}