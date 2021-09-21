<?php

namespace App\Model;

class Comment extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm->select('comment.id', 'user.username AS user', 'user.image AS userPicture', 'comment.note', 'comment.content');
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('comment');
    }

    protected static function with(Orm $orm): Orm{
        return $orm
        ->with('user', 'user_id', 'user.id');
    }
    
}