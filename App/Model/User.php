<?php

namespace model;

class User extends Model{

    public function getAllUsers() :array{
        return $this->getAll('user', ['id', 'Username', 'password']);
    }

}