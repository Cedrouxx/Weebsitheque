<?php

namespace App\Controller;

class DiverController extends Controller{

    /* waifu page (draw waifu picture) */
    public function waifu() :void{
        $this->lunchPage('diver/waifu', 'Waifu');
    }

}