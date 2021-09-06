<?php

use App\Controller\ErrorController;

function redirect(string $location): void{
    header("Location: $location");
    exit;
}

function redirectToLastPage(): void{
    header("Location: {$_SERVER["HTTP_REFERER"]}");
    exit;
}

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