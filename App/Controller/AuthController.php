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

        $userModel = new User();
        $user = $userModel->getOneByMail($_POST['email']);

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

        $userModel = new User;
        $userModel->insertOneUser($_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));

        redirect('login');
    }

    public function logout() :void{
        if(Session::isLogin())
            Session::logout();
        
        redirect('/');
    }

}