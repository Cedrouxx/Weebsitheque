<?php

namespace App\Model;

class Author extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm;
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('author');
    }

    protected static function with(Orm $orm): Orm{
        return $orm;
    }

}