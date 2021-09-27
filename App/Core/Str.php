<?php

namespace App\Core;

class Str{

    /* return a slug */
    public static function slug(string $string){
        $result = str_replace([' ', ':', '/', '\\', '@', ';', '\''], '-', strtolower($string));
        $result = str_replace(['?', '!'], '', $result);
        return $result;
    }

}