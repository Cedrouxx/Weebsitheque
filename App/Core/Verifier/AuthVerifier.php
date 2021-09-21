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

        $user = User::where('email', $loginData['email'])->getOne();

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

        if(strlen($loginData['username']) < 3)
            $result[] =  [ 'error' => 'Le nom d\'utilisateur doit avoir au moin 3 carractères !' ];

        if(!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) 
            $result[] =  [ 'error' => 'L\'adresse mail est incorect !' ];

        if(empty(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $loginData['password']))){
            $result[] =  [ 'error' => 'Le mot de passe doit contenir au moin 8 carractères, une lettre majuscule, une lettre minuscule, un nombre et un carractère spécial (!, @, #, \$, %, \^, &, \*) !' ];
        }

        if($loginData['password'] !== $loginData['password-confirm'])
            $result[] =  [ 'error' => 'Les mots-de-passe ne corresponde pas !' ];

        $user = User::where('email', $loginData['email'])->getOne();
        if(isset($user->id))
            $result[] =  [ 'error' => 'Adresse mail déjà utilisé !' ];

        return $result;
    }

    public static function username($usernameData){
        
        $result = [];

        if(!isset($usernameData['username']) || empty($usernameData['username'])) 
            $result[] = [ 'error' => 'Champ \'Nom d\'utilisateur\' non renseigné !' ];

        if(strlen($usernameData['username']) < 3)
            $result[] =  [ 'error' => 'Le nom d\'utilisateur doit avoir au moin 3 carractères !' ];

        return $result;

    }

    public static function email($emailData){
        
        $result = [];

        if(!isset($emailData['email']) || empty($emailData['email'])) 
            $result[] = [ 'error' => 'Champ \'Adresse mail\' non renseigné !' ];

        if(!filter_var($emailData['email'], FILTER_VALIDATE_EMAIL)) 
            $result[] =  [ 'error' => 'L\'adresse mail est incorect !' ];

        $user = User::where('email', $emailData['email'])->getOne();
        if(isset($user->id))
            $result[] =  [ 'error' => 'Adresse mail déjà utilisé !' ];

        return $result;

    }

    public static function password($passwordData){
        
        $result = [];

        if(!isset($passwordData['password']) || empty($passwordData['password'])) 
            $result[] =  [ 'error' => 'Champ \'Mot-de-passe\' non renseigné !' ];

        if(!isset($passwordData['password-confirm']) || empty($passwordData['password-confirm'])) 
            $result[] =  [ 'error' => 'Champ \'Confirmation du mot-de-passe\' non renseigné !' ];

        if(empty(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $passwordData['password'])))
            $result[] =  [ 'error' => 'Le mot de passe doit contenir au moin 8 carractères, une lettre majuscule, une lettre minuscule, un nombre et un carractère spécial (!, @, #, \$, %, \^, &, \*) !' ];
        

        if($passwordData['password'] !== $passwordData['password-confirm'])
            $result[] =  [ 'error' => 'Les mots-de-passe ne corresponde pas !' ];

        return $result;

    }

    public static function profilePicture(array $file){
        if(!isset($file['profilePicture']) || $file['profilePicture']['error'] > 0)
            $result[] = [ 'error' => 'Champ \'image\' non renseigné ou invalide !' ];

        return $result ?? [];
    }

}