<?php

namespace App\Controller;

use App\Model\Artwork;
use App\Model\Comment;
use App\Model\UserList;
use App\Core\Session;
use App\Core\Verifier\ArtworkVerifier;

class ArtworkController extends Controller{

    /* search page artwork  */
    public function search(string $type) :void{

        if($type === 'anime'){
            $data['list'] = Artwork::where('type', 'Anime')->getAll();
            $data['type'] = 'Anime';
        }else if($type === 'manga'){
            $data['list'] = Artwork::where('type', 'Manga')->getAll();
            $data['type'] = 'Manga';
        }else{
            abord(404);
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

    /* info page artwork */
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

    /* post add comment */
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

    /* page of artwork in user list */
    public function myList(string $type = 'all'){

        if(!Session::isLogin())
            redirect('/');

        if($type === 'all'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->orderBy('artwork.name')->getAll();
            $data['titleType'] = '';
        }else if($type === 'anime'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type', 'Anime')->orderBy('artwork.name')->getAll();
            $data['titleType'] = 'd\'anime';
        }else if($type === 'manga'){
            $data['list'] = UserList::where('user_list.user_id', Session::getUser()['id'])->where('type', 'Manga')->orderBy('artwork.name')->getAll();
            $data['titleType'] = 'de manga';
        }else{
            abord(404);
        }

        $data['type'] = $type;
        $data['isLogin'] = true;

        $data['isUserList'] = true;

        $data['myList'] = true;

        $this->lunchPage('artwork/myList', 'Ma liste', $data);
    } 

    /* post remove in user list */
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

    /* post add in user list */
    public function addList(){

        if(!Session::isLogin())
            redirect('/');
        
        if(!ArtworkVerifier::removeList($_POST))
            redirectToLastPage();

        if(!isset(UserList::where('user.id', Session::getUser()['id'])->where('artwork.id', intval($_POST['artwork_id']))->id))
            UserList::values([
                'user_id' => Session::getUser()['id'],
                'artwork_id' => $_POST['artwork_id']
            ])->insert();
        
        redirectToLastPage();
    }

    /* post set status of one artwork in user list */
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