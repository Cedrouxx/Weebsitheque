<?php

namespace App\Controller;

use model\User;
use Throwable;

class DefaultController extends Controller{

    public function home() :void{
        $this->lunchPage('home', 'Accueil');
    }

}