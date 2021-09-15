<?php

namespace App\Controller;

use App\Core\Verifier\AuthVerifier;
use App\Core\Session;
use App\Model\User;

class AuthController extends Controller{

    public function login() :void{

        if(Session::isLogin())
            redirect('/');

        $messages = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/login', 'Connection', ['messages' => $messages]);
    }

    public function loginPost() :void{

        $verifier = AuthVerifier::loginForm($_POST);

        if(!empty($verifier)){
            Session::addMessage($verifier);
            redirect('login');
        }

        
        $user = User::where('user.email', $_POST['email'])->getOne();
        

        Session::login($user->id, $user->username, $_POST['email'], $user->is_admin);

        redirect('/');
    }

    public function register() :void{

        if(Session::isLogin())
            redirect('/');

        $messages = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/register', 'Inscription', ['messages' => $messages]);
    }

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

    public function logout() :void{
        if(Session::isLogin())
            Session::logout();
        
        redirect('/');
    }

    public function myAccount(){

        if(!Session::isLogin())
            redirect('/');

        $data['user'] = Session::getUser();
        
        $data['messages'] = Session::getMessage();
        Session::clearMessage();

        $this->lunchPage('auth/myAccount', 'Mon compte', $data);
    }

    public function changeUsername(){
        
        if(!Session::isLogin())
            redirect('/');

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
        Session::login($user['id'], $user['username'], $user['email'], $user['isAdmin']);

        Session::addMessage([['success' => 'Nom d\'utilisateur modifier !']]);

        redirect('my-account');


    }

    public function changeEmail(){
        
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
        Session::login($user['id'], $user['username'], $user['email'], $user['isAdmin']);

        Session::addMessage([['success' => 'Adresse mail modifier !']]);

        redirect('/my-account');

    }

    public function changePassword(){
        
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