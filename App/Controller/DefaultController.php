<?php

namespace App\Controller;

use App\Core\Math;
use App\Core\Session;
use App\Model\Artwork;

class DefaultController extends Controller{

    public function home() :void{

        $data['isLogin'] = Session::isLogin();

        //best anime
        $artworks = Artwork::select('artwork.id', 
                                    'artwork.name', 
                                    'artwork.slug',
                                    'author.name AS author', 
                                    'number_volume', 
                                    'type.name AS type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note')
                    ->where('type.name', 'Anime')
                    ->groupBy('artwork.id')
                    ->orderBy('note DESC')
                    ->getAll();
        foreach($artworks as $key => $artwork){
            if($key < 5){
                $data['bestMark']['anime'][] = $artwork;
            }
        }

        // best manga
        $artworks = Artwork::select('artwork.id', 
                                    'artwork.name', 
                                    'artwork.slug',
                                    'author.name AS author', 
                                    'number_volume', 
                                    'type.name AS type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note')
                    ->where('type.name', 'Manga')
                    ->groupBy('artwork.id')
                    ->orderBy('note DESC')
                    ->getAll();
        foreach($artworks as $key => $artwork){
            if($key < 5){
                $data['bestMark']['manga'][] = $artwork;
                if(is_array($artwork->note)){
                    $data['bestMark']['manga'][$key]->note = Math::average(...$artwork->note);
                }
            }
        }

        // new anime
        foreach(Artwork::where('type.name', 'Anime')->getAll() as $key => $artwork){
            if($key < 5){
                $data['new']['anime'][] = $artwork;
                if(is_array($artwork->note)){
                    $data['new']['anime'][$key]->note = Math::average(...$artwork->note);
                }
            }
        }

        // new manga
        foreach(Artwork::where('type.name', 'Manga')->getAll() as $key => $artwork){
            if($key < 5){
                $data['new']['manga'][] = $artwork;
                if(is_array($artwork->note)){
                    $data['new']['manga'][$key]->note = Math::average(...$artwork->note);
                }
            }
        }

        $this->lunchPage('home', 'Accueil', $data);
    }

}