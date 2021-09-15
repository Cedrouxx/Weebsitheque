<?php

namespace App\Controller;

use App\Core\Math;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;
use App\Model\Artwork;
use App\Model\Status;
use App\Model\UserList;

class ApiController extends Controller{

    public function UserListChangeStatus(): void{
        echo json_encode($_POST);
        if(!ArtworkVerifier::setStatusList($_POST) || !Session::isLogin()){
            exit;
        }
        
        if(isset(UserList::where('user_list.user_id', Session::getUser()['id'])->where('user_list.artwork_id', $_POST['artwork_id'])->getOne()->id)){
            UserList::values([ 'user_list_status_id' => $_POST['status'] ])
            ->where('user_id' ,Session::getUser()['id'])
            ->where('artwork_id', $_POST['artwork_id'])
            ->update();
            exit;
        }
    }

    public function RemoveArtworkList(): void{
        if(!Session::isLogin())
            exit;

        if(!ArtworkVerifier::removeList($_POST))
            exit;

        if(isset(UserList::where('user_list.user_id', Session::getUser()['id'])->where('user_list.artwork_id', $_POST['artwork_id'])->getOne()->id))
            UserList::where('user_id', Session::getUser()['id'])
            ->where('artwork_id', $_POST['artwork_id'])
            ->delete();
    }

    public function AddArtworkList(): void{
        if(!Session::isLogin())
            exit;

        if(!ArtworkVerifier::removeList($_POST))
            exit;

        if(!isset(UserList::where('user_list.user_id', Session::getUser()['id'])->where('user_list.artwork_id', $_POST['artwork_id'])->getOne()->id))
            UserList::values([
                'user_id' => Session::getUser()['id'],
                'artwork_id' => $_POST['artwork_id']
            ])->insert();
    }

    public function getArtworks($type = 'all'){

        if($type === 'anime'){
            $data['list'] = Artwork::where('artwork.type', 'Anime')->getAll();
            $data['type'] = 'Anime';
        }else if($type === 'manga'){
            $data['list'] = Artwork::where('artwork.type', 'Manga')->getAll();
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

        if(Session::isLogin()){

            if($type === 'anime'){
                $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type.name', 'Anime')->getAll();
            }else if($type === 'manga'){
                $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type.name', 'Manga')->getAll();
            }else{
                $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->getAll();
            }
            
            if(isset($_GET['id'])){
                foreach($userList as $artwork){
                    if($artwork->id === $_GET['id']){
                        echo json_encode($userList);
                        exit;
                    }
                }
            }

        }
        if(!empty($userList))
            echo json_encode($userList);
        else
            echo json_encode([]);
    }

    public function getArtwork($type = 'all'){

        if($type === 'anime'){
            $userList = Artwork::where('type.name', 'Anime')->getAll();
        }else if($type === 'manga'){
            $userList = Artwork::where('type.name', 'Manga')->getAll();
        }else{
            $userList = Artwork::getAll();
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

    public function getStatus(){

        echo json_encode( Status::getAll() ?? [] );

    }

}