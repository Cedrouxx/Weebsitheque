<?php

namespace App\Controller;

use model\User;
use Throwable;

class AnimeController extends Controller{

    public function search() :void{
        $this->lunchPage('artwork/search', 'Recherche');
    }

}