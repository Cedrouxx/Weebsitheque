<?php

declare(strict_types = 1);

require 'helpers.php';

use App\Core\Session;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

Session::start();

$routes = require 'route.php';

$url = explode('?',$_SERVER['REQUEST_URI'])[0];

if(!isset($routes[$url]))
    abord(404);


[ 'class' => $class, 'method' => $method] = $routes[$url];

$controller = new $class;
$controller->$method();

