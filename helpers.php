<?php

use App\Controller\ErrorController;

function redirect(string $location): void{
    header("Location: $location");
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