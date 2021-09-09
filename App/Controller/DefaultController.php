<?php

namespace App\Controller;


class DefaultController extends Controller{

    public function home() :void{
        $this->lunchPage('home', 'Accueil');
    }

}