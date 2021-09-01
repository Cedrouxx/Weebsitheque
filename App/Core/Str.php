<?php

namespace App\Core;

class Str{

    public static function slug(string $string){
        return str_replace([' ', ':', '/', '\\', '@', ';'], '-', strtolower($string));
    }

}