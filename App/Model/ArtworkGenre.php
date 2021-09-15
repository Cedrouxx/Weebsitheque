<?php
namespace App\Model;

class ArtworkGenre extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm;
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('artwork_genre');
    }

    protected static function with(Orm $orm): Orm{
        return $orm
        ->with('user', 'user_id', 'user.id');
    }

}