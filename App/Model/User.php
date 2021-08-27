<?php

namespace App\Model;

class User extends Model{

    public function getAllUsers() :array{
        return $this->get('user', ['id', 'username', 'password']);
    }

    public function getOneByMail(string $email){
        return $this->getOne('user', ['id', 'username', 'password'], new WhereMaker('email = ?', ['email'], [$email]));
    }

    public function insertOneUser(string $username, string $email, string $password) :void{
        $this->insert('user', [

            'username' => $username,
            'email' => $email,
            'password' => $password

        ]);
    }

}