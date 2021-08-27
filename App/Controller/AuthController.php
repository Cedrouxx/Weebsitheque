<?php

namespace App\Controller;

use App\Core\AuthVerifier;
use App\Core\Session;
use App\Model\User;

class AuthController extends Controller{

    public function login() :void{
        $this->lunchPage('auth/login', 'Connection');
    }

    public function loginPost() :void{
        var_dump($_POST);
    }

    public function register() :void{
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
        $userModel->insertOneUser($_POST['username'], $_POST['email'], $_POST['password']);

        redirect('login');
    }

}