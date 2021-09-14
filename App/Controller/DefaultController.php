<?php

namespace App\Controller;

use App\Core\Math;
use App\Core\Session;
use App\Model\Artwork;

class DefaultController extends Controller{

    public function home() :void{

        $data['isLogin'] = Session::isLogin();
        // var_dump($data['isLogin']);

        $data['bestMark']['anime'] = (new Artwork)->getAllAnime();

        foreach($data['bestMark']['anime'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['bestMark']['anime'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $data['bestMark']['manga'] = (new Artwork)->getAllManga();

        foreach($data['bestMark']['manga'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['bestMark']['manga'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $data['new']['anime'] = (new Artwork)->getAllAnime();

        foreach($data['new']['anime'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['new']['anime'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $data['new']['manga'] = (new Artwork)->getAllManga();

        foreach($data['new']['manga'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['new']['manga'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $this->lunchPage('home', 'Accueil', $data);
    }

}