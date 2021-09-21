<?php 

namespace App\Controller;

use App\Core\Session;

abstract class Controller{

    protected function lunchPage(string $view, string $title, array $data = [], string $layout = 'main') :void{

        $userIsLogin = Session::isLogin();
        if($userIsLogin)
            $user = Session::getUser();

        $view = "view/${view}View.phtml";
        require "view/layout/$layout.phtml";
    }

} 