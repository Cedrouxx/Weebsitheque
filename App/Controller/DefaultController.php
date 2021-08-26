<?php

namespace App\Controller;

use model\User;
use Throwable;

class DefaultController extends Controller{

    public function home() :void{
        $this->lunchPage('home', 'Liste d\'utilisateurs');
    }

    public function user_list() :void{
        $userModel = new User();

        $this->lunchPage('userList', 'Liste d\'utilisateurs', ['users' => $userModel->getAllUsers()]);
    }

}