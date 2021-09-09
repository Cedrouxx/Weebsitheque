<?php

namespace App\Core\Verifier;

class ArtworkVerifier{

    public static function commentForm(array $commentData): array{

        $result = [];

        if(!isset($commentData['artwork_id']) || empty($commentData['artwork_id'])) 
            $result[] = [ 'error' => 'Une érreur est survenue, veuillez réessayer !' ];

        if(!isset($commentData['note']) || empty($commentData['note'])) 
            $result[] = [ 'error' => 'Champ \'note\' non renseigné !' ];

        if(!isset($commentData['content']) || empty($commentData['content'])) 
            $result[] = [ 'error' => 'Vous devez mettre un commentaire !' ];

        if(!empty($result))
            return $result;

        if(!intval($commentData['note'])) 
            $result[] = [ 'error' => 'La note doit être un nombre !' ];

        if(!empty($result))
            return $result;
            
        if($commentData['note'] < 0 || $commentData['note'] > 10 ) 
            $result[] = [ 'error' => 'La note doit être entre 0 est 10 !' ];

        return $result;
    }

    public static function removeList(array $removeData): bool{
        if(!isset($removeData['artwork_id']) || empty($removeData['artwork_id'])) 
            return false;

        return true;
    }

    public static function setStatusList(array $setStatusData): bool{
        if(!ArtworkVerifier::removeList($setStatusData)) 
            return false;

        if(!isset($setStatusData['status']) || empty($setStatusData['status'])) 
            return false;


        return true;
    }

}