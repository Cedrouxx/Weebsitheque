<?php

namespace App\Controller;

use App\Model\Artwork;

class AnimeController extends Controller{

    public function search() :void{
        $artworkModels = new Artwork;
        $data['type'] = 'Anime';
        $data['list'] = $artworkModels->getAllAnime();
        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

}