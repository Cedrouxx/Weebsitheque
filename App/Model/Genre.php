<?php

namespace App\Model;

class Genre extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm;
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('genre');
    }

    protected static function with(Orm $orm): Orm{
        return $orm;
    }

    // public function getAllGenre(): array{
    //     return $this->select('id', 'name')
    //     ->from('genre')
    //     ->getAll();
    // }

}