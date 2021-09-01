<?php

namespace App\Core\Verifier;

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


        return $result;
    }

}