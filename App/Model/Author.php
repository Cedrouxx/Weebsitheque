<?php

namespace App\Model;

class Author extends Model{

    public function getAllAuthor(): array{
        return $this->select('id', 'name')
        ->from('author')
        ->getAll();
    }

}