<?php

namespace App\Controller;

use App\Model\Artwork;

class MangaController extends Controller{

    public function search() :void{
        $artworkModels = new Artwork;
        $data['type'] = 'Manga';
        $data['list'] = $artworkModels->getAllManga();
        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

}