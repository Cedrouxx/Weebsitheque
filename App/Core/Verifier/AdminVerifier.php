<?php

namespace App\Core\Verifier;

use App\Model\Author;
use App\Model\Genre;
use DateTime;

class AdminVerifier{

    public static function artworkForm(array $artworkData, array $file): array{

        $result = [];

        if(!isset($artworkData['type']) || empty($artworkData['type'])) 
            $result[] = [ 'error' => 'Une érreur est survenue, veuillez réessayer !' ];

        if(!isset($artworkData['name']) || empty($artworkData['name'])) 
            $result[] = [ 'error' => 'Champ \'nom\' non renseigné !' ];

        if(!isset($artworkData['author']) || empty($artworkData['author'])) 
            $result[] = [ 'error' => 'Champ \'author\' non renseigné !' ];

        if(!isset($artworkData['number_volume']) || empty($artworkData['number_volume'])) 
            $result[] = [ 'error' => 'Champ \'nombre d\'épisode\' non renseigné !' ];
            
        if(!isset($artworkData['genres']) || empty($artworkData['genres']))
            $result[] = [ 'error' => 'Veuillez selectionner au moin un genre !' ];

        if(!isset($file['image']) || $file['image']['error'] > 0)
            $result[] = [ 'error' => 'Champ \'image\' non renseigné ou invalide !' ];

        $d = DateTime::createFromFormat('Y-m-d', $_POST['release_date']);
        if(!isset($artworkData['release_date']) || !($d && $d->format('Y-m-d') === $_POST['release_date']))
            $result[] = [ 'error' => 'Champ \'date\' non renseigné ou invalide !' ];



        return $result;
    }

    public static function authorForm(array $authorData){

        $result = [];

        if(!isset($authorData['name']) || empty($authorData['name'])) 
            $result[] = [ 'error' => 'Champ \'nom\' non renseigné !' ];

        if(!empty($result))
            return $result;

        $author = Author::select('name')->where('name', $authorData['name'])->getOne();
        if(isset($author->name)) 
            $result[] = [ 'error' => 'L\'auteur/studios est déjà enregistré !' ];

        return $result;
    }

    public static function genreForm(array $genreData){

        $result = [];

        if(!isset($genreData['name']) || empty($genreData['name'])) 
            $result[] = [ 'error' => 'Champ \'nom\' non renseigné !' ];

        if(!empty($result))
            return $result;

        $genre = Genre::select('name')->where('name', $genreData['name'])->getOne();
        if(isset($genre->name)) 
            $result[] = [ 'error' => 'L\'auteur/studios est déjà enregistré !' ];

        return $result;
    }

    public static function artworkEditForm(array $artworkData, array $file): array{

        $result = [];

        if(!isset($artworkData['type']) || empty($artworkData['type']) || !isset($artworkData['id']) || empty($artworkData['id'])) 
            $result[] = [ 'error' => 'Une érreur est survenue, veuillez réessayer !' ];

        if(!isset($artworkData['name']) || empty($artworkData['name'])) 
            $result[] = [ 'error' => 'Champ \'nom\' non renseigné !' ];

        if(!isset($artworkData['author']) || empty($artworkData['author'])) 
            $result[] = [ 'error' => 'Champ \'author\' non renseigné !' ];

        if(!isset($artworkData['number_volume']) || empty($artworkData['number_volume'])) 
            $result[] = [ 'error' => 'Champ \'nombre d\'épisode\' non renseigné !' ];
            
        if(!isset($artworkData['genres']) || empty($artworkData['genres']))
            $result[] = [ 'error' => 'Veuillez selectionner au moin un genre !' ];

        if(isset($file['image']) && $_FILES['image']['name'] !== '' && $file['image']['error'] > 0)
            $result[] = [ 'error' => 'Champ \'image\' invalide !' ];

        $d = DateTime::createFromFormat('Y-m-d', $_POST['release_date']);
        if(!isset($artworkData['release_date']) || !($d && $d->format('Y-m-d') === $_POST['release_date']))
            $result[] = [ 'error' => 'Champ \'date\' non renseigné ou invalide !' ];



        return $result;
    }

    public static function authorEditForm(array $authorData){

        if(!isset($authorData['id']) || empty($authorData['id'])) 
            return [[ 'error' => 'Une érreur est survenue, veuillez réessayer !' ]];

        if(!isset($authorData['name']) || empty($authorData['name'])) 
            return [[ 'error' => 'Champ \'nom\' non renseigné !' ]];

        return [];
    }

}