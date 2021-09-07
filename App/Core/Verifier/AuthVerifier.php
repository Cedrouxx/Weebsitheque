<?php

namespace App\Core\Verifier;

use App\Model\User;

class AuthVerifier{

    public static function loginForm(array $loginData): array{

        $result = [];

        if(!isset($loginData['email']) || empty($loginData['email'])) 
            $result[] = [ 'error' => 'Champ \'Adresse mail\' non renseigné !' ];

        if(!isset($loginData['password']) || empty($loginData['password'])) 
            $result[] = [ 'error' => 'Champ \'Mot-de-passe\' non renseigné !' ];

        if(!empty($result))
            return $result;
        
        if(!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) 
            $result[] =  [ 'error' => 'L\'adresse mail est incorect !' ];
        
        if(!empty($result))
            return $result;

        $userModel = new User();
        $user = $userModel->getOneByMail($loginData['email']);

        if(!isset($user->password) || !password_verify($loginData['password'], $user->password)) 
            $result[] = [ 'error' => 'Adresse mail ou mot-de-passe incorrect' ];

        return $result;
    }

    public static function registerForm(array $loginData): array{

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

        $userModel = new User();

        if(strlen($loginData['username']) < 3)
            $result[] =  [ 'error' => 'Le nom d\'utilisateur doit avoir au moin 3 carractères !' ];

        if(!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) 
            $result[] =  [ 'error' => 'L\'adresse mail est incorect !' ];

        if(empty(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $loginData['password']))){
            $result[] =  [ 'error' => 'Le mot de passe doit contenir au moin une lettre majuscule, une lettre minuscule, un nombre et un carractère spécial (!, @, #, \$, %, \^, &, \*) !' ];
        }

        if($loginData['password'] !== $loginData['password-confirm'])
            $result[] =  [ 'error' => 'Les mots-de-passe ne corresponde pas !' ];

        if(isset($userModel->getOneByMail($loginData['email'])->id))
            $result[] =  [ 'error' => 'Adresse mail déjà utilisé !' ];

        return $result;
    }

}