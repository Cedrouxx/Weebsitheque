<?php

namespace App\Model;

class User extends Model{

    public function getAllUsers(): array{
        return $this->from('user')->getAll();
    }

    public function getOneByMail(string $email): ModelOutput{
        return $this->from('user')->where('email', $email)->getOne();
    }

    public function insertOneUser(string $username, string $email, string $password) :void{
        $this->from('user')->values([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ])->insert();
    }

}