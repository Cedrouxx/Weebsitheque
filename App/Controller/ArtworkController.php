<?php

namespace App\Controller;

use App\Model\Artwork;
use App\Model\Comment;
use App\Model\Status;
use App\Model\UserList;
use App\Core\Math;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;

class ArtworkController extends Controller{

    public function search(string $type) :void{

        if($type === 'anime'){
            $data['list'] = Artwork::where('type.name', 'Anime')->getAll();
            $data['type'] = 'Anime';
        }else if($type === 'manga'){
            $data['list'] = Artwork::where('type.name', 'Manga')->getAll();
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
            $userList = UserList::where('user_list.user_id', Session::getUser()['id'])->getAll();
            foreach($userList as $userArtwork){
                $data['user_list'][$userArtwork->id] = $userArtwork->status;
            }
        }

        $this->lunchPage('artwork/search', 'Recherche', $data);
    }

    public function info(string $type, string $ArtworkSlug){

        if(!isset($ArtworkSlug))
            redirect("$type/search");

        $data['artwork'] = Artwork::where('artwork.slug', $ArtworkSlug)->getOne();


        if(!isset($data['artwork']->slug))
            redirect("$type/search");

        $data['comments'] = Comment::where('comment.artwork_id', $data['artwork']->id)->getAll();

        $data['isLogin'] = Session::isLogin();

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('artwork/info', $data['artwork']->name, $data);
    }

    public function addComment(string $type){
        
        $verifier = ArtworkVerifier::commentForm($_POST);
        $artwork = Artwork::where('artwork.id', $_POST['artwork_id'])->getOne();

        if(!isset($artwork->id))
            redirect("$type/search");
        
        if(!Session::isLogin())
            redirect("$type/info/$artwork->slug");

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect("$type/info/$artwork->slug");
        }

        Comment::values([
            'user_id' => Session::getUser()['id'],
            'artwork_id' => $_POST['artwork_id'],
            'note' => $_POST['note'],
            'content' => $_POST['content'],
        ])->insert();

        redirect("$type/info/$artwork->slug");

    }

    public function myList(string $type = 'all'){

        if(!Session::isLogin())
            redirect('/');

        if($type === 'all'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->orderBy('artwork.name')->getAll();
            $data['titleType'] = '';
        }else if($type === 'anime'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type.name', 'Anime')->orderBy('artwork.name')->getAll();
            $data['titleType'] = 'd\'anime';
        }else if($type === 'manga'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type.name', 'Manga')->orderBy('artwork.name')->getAll();
            $data['titleType'] = 'de manga';
        }else{
            abord(404);
        }

        $data['type'] = $type;
        $data['isLogin'] = true;

        $data['status'] = Status::getAll();

        foreach($data['list'] as $key => $artwork){
            if(is_array($artwork->note)){
                $data['list'][$key]->note = Math::average(...$artwork->note);
            }
        }

        $this->lunchPage('artwork/myList', 'Ma liste', $data);
    } 

    public function removeList(){
        if(!Session::isLogin())
            redirect();
        
        if(!ArtworkVerifier::removeList($_POST))
            redirectToLastPage();

        if(isset(UserList::where('user.id', Session::getUser()['id'])->where('artwork.id', intval($_POST['artwork_id']))->getOne()->id))
            UserList::where('user_id', Session::getUser()['id'])
            ->where('artwork_id', $_POST['artwork_id'])
            ->delete();

        redirectToLastPage();
    }

    public function addList(){
        
        var_dump($_POST);

        if(!Session::isLogin())
            redirect('/');
        
        if(!ArtworkVerifier::removeList($_POST))
            redirectToLastPage();

        $artworkModel = new Artwork();
        if(!isset(UserList::where('user.id', Session::getUser()['id'])->where('artwork.id', intval($_POST['artwork_id']))->id))
            UserList::values([
                'user_id' => Session::getUser()['id'],
                'artwork_id' => $_POST['artwork_id']
            ])->insert();
        
        redirectToLastPage();
    }

    public function setListStatus(){
        
        if(!Session::isLogin())
            redirect('/');

        if(!ArtworkVerifier::setStatusList($_POST))
            redirectToLastPage();

        if(isset(UserList::where('user.id', Session::getUser()['id'])->where('artwork.id', intval($_POST['artwork_id']))->id))
            UserList::values([ 'user_list_status_id' => $_POST['status'] ])
            ->where('user_id' ,Session::getUser()['id'])
            ->where('artwork_id', $_POST['artwork_id'])
            ->update();

        redirectToLastPage();
    }   

}