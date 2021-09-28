<?php

class Router{

    private array $routeList = [];
    private array $keyRouteList = [];
    private string $url = '';
    private string $reg = '';

    public function __construct(){
        
        $this->routeList = require 'route.php';
        $this->url = '/'.($_GET['url'] ?? '');
        $this->reg = '#(:[^\/]+)#';
        $this->keyRouteList = array_keys($this->routeList);

        $this->start(...$this->search());

    }

    /* search a route */
    public function search(): array{

        foreach ($this->keyRouteList as $route){
            
            $routeReg = '#^'.preg_replace($this->reg, '([^\/]+)', $route).'$#';
            
            $result = '';
            $match = preg_match($routeReg, $this->url, $result);
    
            if($match){

                unset($result[0]);

                return [
                    'routeFind' => $route,
                    'routeParameter' => $result
                ];
    
            }
    
        }

        return [
            'routeFind' => '',
            'routeParameter' => []
        ];
    }

    /* start a route */
    public function start(string $routeFind, array $routeParameter): void{

        if(empty($routeFind))
            abord(404);
    
        [ 'class' => $class, 'method' => $method] = $this->routeList[$routeFind];
    
        (new $class)->$method(...$routeParameter ?? []);
        
    }



}