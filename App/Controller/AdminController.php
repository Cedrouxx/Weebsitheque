<?php

namespace App\Controller;

use App\Core\Verifier\AdminVerifier;
use App\Core\Session;
use App\Core\Str;
use App\Model\Artwork;
use App\Model\ArtworkGenre;
use App\Model\Author;
use App\Model\Comment;
use App\Model\Genre;
use App\Model\UserList;

class AdminController extends Controller{

    /* index of admin */
    public function index(): void{

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $data['animes'] = Artwork::where('type', 'Anime')->getAll();
        $data['mangas'] = Artwork::where('type', 'Manga')->getAll();

        $data['authors'] = Author::getAll();

        $data['genres'] = Genre::getAll();

        $this->lunchPage('admin/index', 'Administration', $data);
    }

    /* add one artwork */
    public function addArtwork(): void{

        $messages = AdminVerifier::artworkForm($_POST, $_FILES);

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            redirect('/');

        if(empty($messages)){

            $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $folder = 'ressources/img/artwork/'.($_POST['type'] == 1 ? 'manga' : 'anime').'/'.Str::slug($_POST['name']).'.'.$fileType;
            move_uploaded_file($_FILES['image']['tmp_name'], $folder);

            Artwork::values([
                'name' => $_POST['name'],
                'slug' => Str::slug($_POST['name']),
                'author_id' => $_POST['author'],
                'number_volume' => $_POST['number_volume'],
                'type' => $_POST['type'],
                'image' => $folder,
                'release_date' => $_POST['release_date']
            ])->insert();
            
            foreach($_POST['genres'] as $genreId){
                ArtworkGenre::values([
                    'artwork_id' => Artwork::select('artwork.id')
                                    ->where('artwork.name', $_POST['name'])
                                    ->getOne()
                                    ->id,
                    'genre_id' => $genreId
                ])->insert();
                
            }

        }else{
            Session::addMessage($messages);
        }

        redirect('admin');
    }

    /* remove one artwork */
    public function removeArtwork($artworkId){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        Comment::where('comment.artwork_id', $artworkId)->delete();
        ArtworkGenre::where('artwork_genre.artwork_id', $artworkId)->delete();
        UserList::where('user_list.artwork_id', $artworkId)->delete();
        Artwork::where('artwork.id', $artworkId)->delete();
            
        redirect('admin');
    }

    /* form for edit one artwork */
    public function editArtwork($artworkId){

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data = [];
        $data['type'] = 'artwork';

        $data['messages'] = Session::getMessage();
        Session::clearMessage();
        $data['artwork'] = Artwork::where('artwork.id', $artworkId)->getOne();
        $artworkGenres = ArtworkGenre::select('genre.id','genre.name')->where('artwork_id', $artworkId)->getAll();
        $data['artwork-genres'] = [];
        foreach($artworkGenres as $genre){
            $data['artwork-genres'][] = $genre->name;
        }
        $data['allGenres'] = Genre::getAll();
        $data['allAuthors'] = Author::getAll();

        $this->lunchPage('admin/edit', 'edit-artwork', $data);
    }

    /* post for edit one artwork */
    public function editPostArtwork(){
        
        $messages = AdminVerifier::artworkEditForm($_POST, $_FILES);
        if(!empty($messages)){
            Session::addMessage($messages);
            redirectToLastPage();
        }
        
        
        if(isset($file['image']) && $_FILES['image']['name'] !== '' && !($file['image']['error'] > 0)){
            $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $folder = 'ressources/img/artwork/'.($_POST['type'] === 'Manga' ? 'manga' : 'anime').'/'.Str::slug($_POST['name']).'.'.$fileType;
            move_uploaded_file($_FILES['image']['tmp_name'], $folder);
        }
        else{
            $image = Artwork::select('artwork.id', 'artwork.image')->where('artwork.id', $_POST['id'])->getOne()->image;
            $fileType = pathinfo($image, PATHINFO_EXTENSION);
            $folder = 'ressources/img/artwork/'.($_POST['type'] === 'Manga' ? 'manga' : 'anime').'/'.Str::slug($_POST['name']).'.'.$fileType;
            if ($image !== $folder)
                rename($image, $folder.'.'.$fileType);
        }

        Artwork::where('artwork.id', $_POST['id'])
        ->values([
            'name' => $_POST['name'],
            'slug' => Str::slug($_POST['name']),
            'author_id' => $_POST['author'],
            'number_volume' => $_POST['number_volume'],
            'type' => $_POST['type'],
            'image' => $folder,
            'release_date' => $_POST['release_date']
        ])->update();

        Artwork::where('artwork.id', $_POST['id']);

        exit;
        redirect('admin');
            
    }

    /* add one author */
    public function addAuthor(){

        $messages = AdminVerifier::authorForm($_POST);
        if(!empty($messages)){
            Session::addMessage($messages);
            redirect('admin');
        }

        Author::values([
            'name' => $_POST['name']
        ])->insert();

        redirect('admin');
    }

    /* remove one author */
    public function removeAuthor($authorId){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $artworkList = Artwork::select('artwork.id', 'artwork.name')->where('artwork.author_id', $authorId)->getAll();
        $artworkNameList = [];
        foreach($artworkList as $artwork){
            $artworkNameList[] = $artwork->name;
        }
        if(!empty($artworkList)){
            Session::addMessage([['error' =>  '"'.implode('", "', $artworkNameList).'" contien(nen)t l\'auteur/studio "'.Author::where('author.id', $authorId)->getOne()->name.'" !']]);
            redirect('admin');
        }

        Author::where('author.id', $authorId)->delete();

        redirect('admin');

    }

    /* form for edit one author */
    public function editAuthor($authorId){

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data = [];
        $data['type'] = 'author';

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $data['author'] = Author::where('author.id', $authorId)->getOne();


        $this->lunchPage('admin/edit', 'edit-author', $data);
    }

    /* post for edit one author */
    public function editPostAuthor(){

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $messages = AdminVerifier::authorEditForm($_POST);
        if(!empty($messages)){
            Session::addMessage($messages);
            redirectToLastPage();
        }

        Author::where('author.id', $_POST['id'])
        ->values([
            'name' => $_POST['name']
        ])->update();

        redirect('admin');

    }

    /* add one genre */
    public function addGenre(){

        $messages = AdminVerifier::genreForm($_POST);
        if(!empty($messages)){
            Session::addMessage($messages);
            redirect('admin');
        }

        Genre::values([
            'name' => $_POST['name']
        ])->insert();

        redirect('admin');
    }

    /* remove one genre */
    public function removeGenre($genreId){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        ArtworkGenre::where('genre_id', $genreId)->delete();
        Genre::where('id', $genreId)->delete();

        redirect('admin');
    }

    /* form for edit one genre */
    public function editGenre($genreId){
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data = [];
        $data['type'] = 'genre';

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $data['genre'] = Genre::where('genre.id', $genreId)->getOne();

        $this->lunchPage('admin/edit', 'edit-genre', $data);
    }

    /* post for edit one genre */
    public function editPostGenre(){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $messages = AdminVerifier::authorEditForm($_POST);
        if(!empty($messages)){
            Session::addMessage($messages);
            redirectToLastPage();
        }

        Genre::where('genre.id', $_POST['id'])
        ->values([
            'name' => $_POST['name']
        ])->update();

        redirect('admin');
    }

}