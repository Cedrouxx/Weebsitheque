<?php

namespace App\Controller;

use App\Core\Math;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;
use App\Model\Artwork;

class ApiController extends Controller{

    public function UserListChangeStatus(): void{
        if(!ArtworkVerifier::setStatusList($_POST) || !Session::isLogin()){
            exit;
        }
        
        $artworkModel = new Artwork();
        if(isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], $_POST['artwork_id'])->id)){
            $artworkModel->updateOneArtworkStatus(Session::getUser()['id'], $_POST['artwork_id'], $_POST['status']);
            exit;
        }
    }

    public function RemoveArtworkList(): void{
        if(!Session::isLogin())
            exit;

        if(!ArtworkVerifier::removelList($_POST))
            exit;

        $artworkModel = new Artwork();
        if(isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], $_POST['artwork_id'])->id))
            $artworkModel->removeOneArtworkInUserList(Session::getUser()['id'], $_POST['artwork_id']);
    }

    public function AddArtworkList(): void{
        if(!Session::isLogin())
            exit;

        if(!ArtworkVerifier::removelList($_POST))
            exit;

        $artworkModel = new Artwork();
        if(!isset($artworkModel->getOneArtworkInUserListByArtworkId(Session::getUser()['id'], $_POST['artwork_id'])->id))
            $artworkModel->insertOneArtworkInUserList(Session::getUser()['id'], $_POST['artwork_id']);
    }

    public function getArtworks($type = 'all'){
        $artworkModel = new Artwork;

        if($type === 'anime'){
            $data['list'] = $artworkModel->getAllAnime();
            $data['type'] = 'Anime';
        }else if($type === 'manga'){
            $data['list'] = $artworkModel->getAllManga();
            $data['type'] = 'Manga';
        }
        
        foreach($data['list'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['list'][$key]->note = Math::average(...$artwork->note);
            }
        }

        

        require 'Api/ArtworkList/GetInHtml.php';
    }

    public function getUserList($type = 'all'){

        $artworkModel = new Artwork;

        if(Session::isLogin()){

            if($type === 'anime'){
                $userList = $artworkModel->getAllAnimeInUserList(Session::getUser()['id']);
            }else if($type === 'manga'){
                $userList = $artworkModel->getAllMangaInUserList(Session::getUser()['id']);
            }else{
                $userList = $artworkModel->getAllArtworkInUserList(Session::getUser()['id']);
            }
            
            if(isset($_GET['id'])){
                foreach($userList as $artwork){
                    if($artwork->id === $_GET['id']){
                        echo json_encode($userList);
                        exit;
                    }
                }
            }

            echo json_encode($userList);
        }

    }

}