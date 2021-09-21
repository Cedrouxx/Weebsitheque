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

    public function removeArtwork($artworkId){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        Comment::where('comment.artwork_id', $artworkId)->delete();
        ArtworkGenre::where('artwork_genre.artwork_id', $artworkId)->delete();
        UserList::where('user_list.artwork_id', $artworkId)->delete();
        Artwork::where('artwork.id', $artworkId)->delete();
            
        redirect('admin');
    }

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

    public function removeAuthor(){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        

    }

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

    public function removeGenre($genreId){
        
        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        ArtworkGenre::where('genre_id', $genreId)->delete();
        Genre::where('id', $genreId)->delete();
    }

}