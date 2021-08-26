<?php
namespace App\Core;

class Session{

    public static function start() :void{
        session_start();
    }

}