<?php

namespace App\Controller;

use App\Core\Verifier\AdminVerifier;
use App\Core\Session;
use App\Core\Str;
use App\Model\Artwork;
use App\Model\ArtworkGenre;
use App\Model\Author;
use App\Model\Genre;

class AdminController extends Controller{

    public function index(): void{

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        // $artworkModel = new Artwork();
        $data['animes'] = Artwork::where('type.name', 'Anime')->getAll();
        $data['mangas'] = Artwork::where('type.name', 'Manga')->getAll();

        $authorModel = new Author();
        $data['authors'] = Author::getAll();

        $genreModel = new Genre();
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
            move_uploaded_file($_FILES['image']['tmp_name'], '.'.$folder);

            $artworkModel = new Artwork();
            Artwork::values([
                'name' => $_POST['name'],
                'slug' => Str::slug($_POST['name']),
                'author_id' => $_POST['author'],
                'number_volume' => $_POST['number_volume'],
                'type_id' => $_POST['type'],
                'image' => $folder
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

}