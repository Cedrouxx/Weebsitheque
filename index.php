<?php

declare(strict_types = 1);

require 'helpers.php';

use App\Core\Session;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

Session::start();

$routes = require 'route.php';

if(!isset($routes[$_SERVER['REQUEST_URI']]))
    abord(404);


[ 'class' => $class, 'method' => $method] = $routes[$_SERVER['REQUEST_URI']];

$controller = new $class;
$controller->$method();

