<?php

namespace App\Controller;

use App\Model\Artwork;
use Throwable;

class AnimeController extends Controller{

    public function search() :void{
        $artworkModels = new Artwork;
        $data['type'] = 'Anime';
        $data['list'] = $artworkModels->getAllAnime();
        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

}