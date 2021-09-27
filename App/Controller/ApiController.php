<?php

namespace App\Controller;

use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;
use App\Model\Artwork;
use App\Model\UserList;

class ApiController extends Controller{

    /* change the status of one artwork in user list  */
    public function UserListChangeStatus(): void{
        
        if(!ArtworkVerifier::setStatusList($_POST) || !Session::isLogin()){
            exit;
        }
        
        if(isset(UserList::where('user_list.user_id', Session::getUser()['id'])->where('user_list.artwork_id', $_POST['artwork_id'])->getOne()->id)){
            UserList::values([ 'user_list.status' => $_POST['status'] ])
            ->where('user_id' ,Session::getUser()['id'])
            ->where('artwork_id', $_POST['artwork_id'])
            ->update();
            exit;
        }
    }

    /* remove one artwork in user list  */
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

    /* add one artwork in user list  */
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

    /* get all artwork in user list */
    public function getUserList($type = 'all'): void{

        if(Session::isLogin()){

            if($type === 'anime'){
                $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type', 'Anime')->getAll();
            }else if($type === 'manga'){
                $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type', 'Manga')->getAll();
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

    /* get all artwork or one type (Anime/Manga) */
    public function getArtwork($type = 'all'): void{

        if($type === 'anime'){
            $userList = Artwork::where('type', 'Anime')->getAll();
        }else if($type === 'manga'){
            $userList = Artwork::where('type', 'Manga')->getAll();
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

    /* get all status */
    public function getStatus(): void{

        echo json_encode([ 'Undefined','To start','In progress','Stopped','Finished' ]);

    }

}