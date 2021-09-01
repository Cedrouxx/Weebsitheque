<?php

namespace App\Model;

class Genre extends Model{

    public function getAllGenre(): array{
        return $this->select('id', 'name')
        ->from('genre')
        ->getAll();
    }

}