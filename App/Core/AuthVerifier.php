<?php

namespace App\Core;

use App\Model\User;

class AuthVerifier{

    public static function loginForm(array $loginData){



    }

    public static function registerForm(array $loginData){

        $userModel = new User();

        $result = [];

        if(!isset($loginData['username']) || empty($loginData['username'])) 
            $result[] = [ 'error' => 'Champ \'Nom d\'utilisateur\' non renseigné !' ];

        if(!isset($loginData['email']) || empty($loginData['email'])) 
            $result[] = [ 'error' => 'Champ \'Adresse mail\' non renseigné !' ];

        if(!isset($loginData['password']) || empty($loginData['password'])) 
            $result[] =  [ 'error' => 'Champ \'Mot-de-passe\' non renseigné !' ];

        if(!isset($loginData['password-confirm']) || empty($loginData['password-confirm'])) 
            $result[] =  [ 'error' => 'Champ \'Confirmation du mot-de-passe\' non renseigné !' ];

        if(!empty($result))
            return $result;

        // if(empty($loginData['username'])) $result[] = 'Champ \'Nom d\'utilisateur\' non renseigné !';
        // if(empty($loginData['email'])) $result[] = 'Champ \'Adresse mail\' non renseigné !';
        // if(empty($loginData['password'])) return false;
        // if(empty($loginData['password-confirm'])) return false;

        if(!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) 
            $result[] =  [ 'error' => 'L\'adresse mail est incorect !' ];

        if($loginData['password'] !== $loginData['password-confirm'])
            $result[] =  [ 'error' => 'Les mots-de-passe ne corresponde pas !' ];

        if(!empty($userModel->getOneByMail($loginData['email'])))
            $result[] =  [ 'error' => 'Adresse mail déjà utilisé !' ];

        return $result;
    }

}