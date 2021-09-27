<?php

namespace App\Core;

class Math{

    /* average integer */
    public static function average(int ...$numbers): float{
        $result = 0;
        foreach($numbers as $number){
            $result += $number; 
        }
        return $result/count($numbers);
    }

}