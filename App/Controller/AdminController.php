<?php

namespace App\Controller;

use App\Core\Verifier\AdminVerifier;
use App\Core\Session;
use App\Core\Str;
use App\Model\Artwork;
use App\Model\Author;
use App\Model\Genre;

class AdminController extends Controller{

    public function index(): void{

        if(!Session::isLogin() || (Session::isLogin() && !Session::getUser()['isAdmin']))
            abord(404);

        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $artworkModel = new Artwork();
        $data['animes'] = $artworkModel->getAllAnime();
        $data['mangas'] = $artworkModel->getAllManga();

        $authorModel = new Author();
        $data['authors'] = $authorModel->getAllAuthor();

        $genreModel = new Genre();
        $data['genres'] = $genreModel->getAllGenre();

        $this->lunchPage('admin/index', 'Administration', $data);
    }

    public function addArtwork(): void{
        var_dump($_POST, $_FILES);

        $messages = AdminVerifier::artworkForm($_POST, $_FILES);

        var_dump($messages);
        if(empty($messages)){

            $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            var_dump($fileType);
            $folder = '/ressources/img/artwork/'.($_POST['type'] == 1 ? 'manga' : 'anime').'/'.Str::slug($_POST['name']).'.'.$fileType;
            move_uploaded_file($_FILES['image']['tmp_name'], '.'.$folder);

            $artworkModel = new Artwork();
            $artworkModel->insertOneArtwork($_POST['name'], $_POST['author'], $_POST['number_volume'], $_POST['type'], $folder);
            foreach($_POST['genres'] as $genreId){
                $artworkModel->AddGenre($artworkModel->getOneArtworkIdByName($_POST['name'])->id, $genreId);
            }

        }else{
            Session::addMessage($messages);
        }

        redirect('/admin');
    }

}