<?php

namespace App\Core;

class Math{

    public static function average(int ...$numbers){
        $result = 0;
        foreach($numbers as $number){
            $result += $number; 
        }
        return $result/count($numbers);
    }

}