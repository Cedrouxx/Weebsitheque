<?php

namespace App\Controller;

use App\Core\Verifier\AuthVerifier;
use App\Core\Session;
use App\Core\Str;
use App\Model\User;

class AuthController extends Controller{

    /* login page */
    public function login() :void{

        if(Session::isLogin())
            redirect('/');

        $messages = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/login', 'Connection', ['messages' => $messages]);
    }

    /* login post */
    public function loginPost() :void{

        $verifier = AuthVerifier::loginForm($_POST);

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('login');
        }

        
        $user = User::where('user.email', $_POST['email'])->getOne();
        

        Session::login($user->id, $user->username, $_POST['email'], $user->image, $user->is_admin);

        redirect('/');
    }

    /* register page */
    public function register() :void{

        if(Session::isLogin())
            redirect('/');

        $messages = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/register', 'Inscription', ['messages' => $messages]);
    }

    /* register post */
    public function registerPost() :void{

        $verifier = AuthVerifier::registerForm($_POST);

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('register');
        }

        User::values([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ])->insert();

        redirect('login');
    }

    /* logout post */
    public function logout() :void{
        if(Session::isLogin())
            Session::logout();
        
        redirect('/');
    }

    /* user account page */
    public function myAccount(): void{

        if(!Session::isLogin())
            redirect('/');

        $data['user'] = Session::getUser();
        
        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/myAccount', 'Mon compte', $data);
    }

    /* change user-picture post */
    public function changeProfilePicture(): void{

        if(!Session::isLogin())
            redirect();

        $message = AuthVerifier::profilePicture($_FILES);
        if(!empty($message)){
            Session::addMessage($message);
            redirect('my-account');
        }

        $fileType = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
        $folder = 'ressources/img/user/'.Str::slug(Session::getUser()['username']).'.'.$fileType;
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], $folder);

        User::values([
            'image' => $folder
        ])->where('id',  Session::getUser()['id'])
        ->update();

        $user = Session::getUser();
        Session::logout();
        Session::login($user['id'], $user['username'], $user['email'], $folder, $user['isAdmin']);
        
        redirect('my-account');
    }

    /* change username post */
    public function changeUsername(): void{
        
        if(!Session::isLogin())
            redirect();

        $verifier = AuthVerifier::username($_POST);
        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('my-account');
        }

        $user = Session::getUser();
        User::values([
            'username' => $user['id']
        ])->where('id', $_POST['username'])
        ->update();

        $user['username'] = $_POST['username'];

        Session::logout();
        Session::login($user['id'], $user['username'], $user['email'], $user['image'], $user['isAdmin']);

        Session::addMessage([['success' => 'Nom d\'utilisateur modifier !']]);

        redirect('my-account');


    }

    /* change email post */
    public function changeEmail(): void{
        
        if(!Session::isLogin())
            redirect('/');

        $verifier = AuthVerifier::email($_POST);
        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('/my-account');
        }

        $user = Session::getUser();
        User::values([
            'email' => $_POST['email']
        ])->where('id', $user['id'])
        ->update();

        $user['email'] = $_POST['email'];

        Session::logout();
        Session::login($user['id'], $user['username'], $user['email'], $user['image'], $user['isAdmin']);

        Session::addMessage([['success' => 'Adresse mail modifier !']]);

        redirect('/my-account');

    }

    /* change password post */
    public function changePassword(): void{
        
        if(!Session::isLogin())
            redirect('/');

        $verifier = AuthVerifier::password($_POST);
        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('/my-account');
        }

        $user = Session::getUser();
        User::values([
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ])->where('id', $user['id'])
        ->update();

        Session::addMessage([['success' => 'Mot-de-passe modifier !']]);

        redirect('/my-account');

    }

}