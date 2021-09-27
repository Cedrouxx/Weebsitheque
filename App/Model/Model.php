<?php

namespace App\Model;

abstract class Model{

    public static function __callStatic($name, $arguments){
        
        $orm = new Orm();
        static::defaultSelect($orm);
        static::from($orm);
        static::with($orm);
        $result = $orm->$name(...$arguments);
        return $result ?? $orm;

    }

    /* default select */
    abstract protected static function defaultSelect(Orm $orm): Orm;
    /* from table */
    abstract protected static function from(Orm $orm): Orm;
    /* default join */
    abstract protected static function with(Orm $orm): Orm;


}