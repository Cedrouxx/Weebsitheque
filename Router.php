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

    public function search(){

        foreach ($this->keyRouteList as $route){
            
            $routeReg = '#^'.preg_replace($this->reg, '([^\/]+)', $route).'$#';
            
            $result = '';
            $match = preg_match($routeReg, $this->url, $result);
    
            if($match){

                unset($result[0]);
    
                $routeFind = $route;
                $routeParameter = $result;
    
            }
    
        }

        return [
            'routeFind' => $routeFind,
            'routeParameter' => $routeParameter
        ];
    }

    public function start($routeFind, $routeParameter){

        if(!isset($routeFind))
            abord(404);
    
        [ 'class' => $class, 'method' => $method] = $this->routeList[$routeFind];
    
        (new $class)->$method(...$routeParameter ?? []);
        
    }



}