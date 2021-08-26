<?php 

namespace App\Controller;

abstract class Controller{

    protected function lunchPage(string $view, string $title, array $data = [], string $layout = 'main') :void{
        $view = "view/${view}View.phtml";
        require "view/layout/$layout.phtml";
    }

} 