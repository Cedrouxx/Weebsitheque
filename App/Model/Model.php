<?php

namespace App\Model;

use App\Core\Str;

abstract class Model{

    public static function __callStatic($name, $arguments){
        
        $orm = new Orm();
        static::defaultSelect($orm);
        static::from($orm);
        static::with($orm);
        $result = $orm->$name(...$arguments);
        return $result ?? $orm;

    }

    abstract protected static function defaultSelect(Orm $orm): Orm;
    abstract protected static function from(Orm $orm): Orm;
    abstract protected static function with(Orm $orm): Orm;


}