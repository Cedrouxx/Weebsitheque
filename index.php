<?php

declare(strict_types = 1);
define('config', require 'config.php');

require 'helpers.php';

use App\Core\Session;
use App\Exception\LangException;
use Lang\Lang;

spl_autoload_register(function ($class_name) {
    include str_replace('\\', '/', $class_name) . '.php';
});

Session::start();

$routes = require 'route.php';

$url = '/'.($_GET['url'] ?? '');

try{
    $lang = new Lang($_GET['lang'] ?? '');
    define('lang', $lang->getLang());
}catch(LangException){
    if ($url === '/')
        redirect($_GET['lang'] ?? '', false);
    redirect('', false);
}

$reg = '#(:[^\/]+)#';
$keyRoutes = array_keys($routes);

$routeFind;
$routeParameter;

foreach ($keyRoutes as $route){
    
    $routeReg = '#^'.preg_replace($reg, '([^\/]+)', $route).'$#';
    
    $result;
    $match = preg_match($routeReg, $url, $result);

    if($match){

        unset($result[0]);

        $routeFind = $route;
        $routeParameter = $result;

    }

}

if(!isset($routeFind))
    abord(404);

[ 'class' => $class, 'method' => $method] = $routes[$routeFind];

$controller = new $class;
$controller->$method(...$routeParameter ?? []);