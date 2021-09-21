<?php

namespace App\Model;

class Status extends Model{

    protected static function defaultSelect(Orm $orm): Orm{
        return $orm;
    }

    protected static function from(Orm $orm): Orm{
        return $orm->from('user_list_status');
    }

    protected static function with(Orm $orm): Orm{
        return $orm;
    }

}