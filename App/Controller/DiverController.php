<?php

namespace App\Controller;

use App\Model\Artwork;

class DiverController extends Controller{

    public function waifu() :void{
        $this->lunchPage('diver/waifu', 'Waifu');
    }

}