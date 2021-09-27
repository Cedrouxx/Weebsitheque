<?php

namespace App\Controller;

use App\Core\Math;
use App\Core\Session;
use App\Model\Artwork;

class DefaultController extends Controller{

    /* home page */
    public function home(): void{

        $data['isLogin'] = Session::isLogin();

        //best anime
        $artworks = Artwork::select('artwork.id', 
                                    'artwork.name', 
                                    'artwork.slug',
                                    'author.name AS author', 
                                    'number_volume', 
                                    'type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note')
                    ->where('type', 'Anime')
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
                                    'type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note')
                    ->where('type', 'Manga')
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
        $artworks = Artwork::select('artwork.id', 
                                    'artwork.name', 
                                    'artwork.slug',
                                    'author.name AS author', 
                                    'number_volume', 
                                    'type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note',
                                    'artwork.release_date')
                    ->where('type', 'Anime')
                    ->groupBy('artwork.id')
                    ->orderBy('artwork.release_date DESC')
                    ->getAll();
        foreach(Artwork::where('type', 'Anime')->getAll() as $key => $artwork){
            if($key < 5){
                $data['new']['anime'][] = $artwork;
                if(is_array($artwork->note)){
                    $data['new']['anime'][$key]->note = Math::average(...$artwork->note);
                }
            }
        }

        // new manga
        $artworks = Artwork::select('artwork.id', 
                                    'artwork.name', 
                                    'artwork.slug',
                                    'author.name AS author', 
                                    'number_volume', 
                                    'type', 
                                    'GROUP_CONCAT( genre.name SEPARATOR \', \' ) AS genre', 
                                    'artwork.image', 
                                    'AVG(comment.note) AS note',
                                    'artwork.release_date')
                    ->where('type', 'Manga')
                    ->groupBy('artwork.id')
                    ->orderBy('artwork.release_date DESC')
                    ->getAll();
        foreach(Artwork::where('type', 'Manga')->getAll() as $key => $artwork){
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