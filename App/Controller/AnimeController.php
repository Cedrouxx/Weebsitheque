<?php

namespace App\Controller;

use App\Model\Artwork;
use App\Model\Comment;
use App\Core\Math;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;

class AnimeController extends Controller{

    public function search() :void{
        $artworkModels = new Artwork;

        $data['type'] = 'Anime';
        $data['list'] = $artworkModels->getAllAnime();
        foreach($data['list'] as $key => $anime){
            if(is_array($anime->note)){
                $data['list'][$key]->note = Math::average(...$anime->note);
            }
        }
        
        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

    public function info(){
        if(!isset($_GET['name']))
            redirect('/anime/search');

        $artworkModel = new Artwork();
        $commentModel = new Comment();

        $data['artwork'] = $artworkModel->getOneArtworkBySlug($_GET['name']);

        if(!isset($data['artwork']->slug))
            redirect('/anime/search');

        $data['comments'] = $commentModel->getAllCommentByArtworkId($data['artwork']->id);

        $data['isLogin'] = Session::isLogin();

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('artwork/info', $data['artwork']->name, $data);
    }

    public function addComment(){

        $artworkModel = new Artwork();

        var_dump($_POST);
        
        $verifier = ArtworkVerifier::commentForm($_POST);
        $artwork = $artworkModel->getOneArtworkById($_POST['artwork_id']);

        if(!isset($artwork->id))
            redirect('http://weebsitheque.fr/anime/search');
        
        if(!Session::isLogin())
            redirect('http://weebsitheque.fr/anime/info?name='.$artwork->slug);

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('http://weebsitheque.fr/anime/info?name='.$artwork->slug);
        }

        $commentModel = new Comment();
        $commentModel->insertOneComment(Session::getUser()['id'], $_POST['artwork_id'], $_POST['note'], $_POST['content']);

        redirect('http://weebsitheque.fr/anime/info?name='.$artwork->slug);

    }

}