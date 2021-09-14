<?php

namespace App\Controller;

use App\Model\Artwork;
use App\Model\Comment;
use App\Core\Math;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;
use App\Model\Status;

class ArtworkController extends Controller{

    public function search(string $type) :void{
        $artworkModel = new Artwork;

        if($type === 'anime'){
            $data['list'] = $artworkModel->getAllAnime();
            $data['type'] = 'Anime';
        }else if($type === 'manga'){
            $data['list'] = $artworkModel->getAllManga();
            $data['type'] = 'Manga';
        }else{
            abord(404);
        }
        
        foreach($data['list'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['list'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $data['isLogin'] = Session::isLogin();

        if($data['isLogin']){
            $userList = $artworkModel->getAllArtworkStatusInUserList(Session::getUser()['id']);
            foreach($userList as $userArtwork){
                $data['user_list'][$userArtwork->id] = $userArtwork->status;
            }
        }

        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

    public function info(string $type, string $ArtworkSlug){

        if(!isset($ArtworkSlug))
            redirect("$type/search");

        $artworkModel = new Artwork();
        $commentModel = new Comment();

        $data['artwork'] = $artworkModel->getOneArtworkBySlug($ArtworkSlug);


        if(!isset($data['artwork']->slug))
            redirect("$type/search");

        $data['comments'] = $commentModel->getAllCommentByArtworkId($data['artwork']->id);

        $data['isLogin'] = Session::isLogin();

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('artwork/info', $data['artwork']->name, $data);
    }

    public function addComment(string $type){

        $artworkModel = new Artwork();
        
        $verifier = ArtworkVerifier::commentForm($_POST);
        $artwork = $artworkModel->getOneArtworkById($_POST['artwork_id']);

        if(!isset($artwork->id))
            redirect("$type/search");
        
        if(!Session::isLogin())
            redirect("$type/info?name=$artwork->slug");

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect("$type/info?name=$artwork->slug");
        }

        $commentModel = new Comment();
        $commentModel->insertOneComment(Session::getUser()['id'], $_POST['artwork_id'], $_POST['note'], $_POST['content']);

        redirect("$type/info?name=$artwork->slug");

    }

    public function myList(string $type = 'all'){

        if(!Session::isLogin())
            redirect('/');

        $artworkModel = new Artwork();
        if($type === 'all'){
            $data['list'] = $artworkModel->getAllArtworkInUserList(Session::getUser()['id']);
            $data['titleType'] = '';
        }else if($type === 'anime'){
            $data['list'] = $artworkModel->getAllAnimeInUserList(Session::getUser()['id']);
            $data['titleType'] = 'd\'anime';
        }else if($type === 'manga'){
            $data['list'] = $artworkModel->getAllMangaInUserList(Session::getUser()['id']);
            $data['titleType'] = 'de manga';
        }else{
            abord(404);
        }

        $data['type'] = $type;
        $data['isLogin'] = true;

        $satusModel = new Status();
        $data['status'] = $satusModel->getAllStatus();

        foreach($data['list'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['list'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $this->lunchPage('artwork/myList', 'Ma liste', $data);
    } 

    public function removeList(){
        if(!Session::isLogin())
            redirect('/');
        
        if(!ArtworkVerifier::removeList($_POST))
            redirectToLastPage();

        $artworkModel = new Artwork();
        if(isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], intval($_POST['artwork_id']))->id))
            $artworkModel->removeOneArtworkInUserList(Session::getUser()['id'], $_POST['artwork_id']);

        redirectToLastPage();
    }

    public function addList(){
        
        var_dump($_POST);

        if(!Session::isLogin())
            redirect('/');
        
        if(!ArtworkVerifier::removeList($_POST))
            redirectToLastPage();

        $artworkModel = new Artwork();
        if(!isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], $_POST['artwork_id'])->id))
            $artworkModel->insertOneArtworkInUserList(Session::getUser()['id'], $_POST['artwork_id']);
        
        redirectToLastPage();
    }

    public function setListStatus(){
        
        if(!Session::isLogin())
            redirect('/');

        if(!ArtworkVerifier::setStatusList($_POST))
            redirectToLastPage();

        $artworkModel = new Artwork();
        if(isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], $_POST['artwork_id'])->id))
            $artworkModel->updateOneArtworkStatus(Session::getUser()['id'], $_POST['artwork_id'], $_POST['status']);

        redirectToLastPage();
    }   

}