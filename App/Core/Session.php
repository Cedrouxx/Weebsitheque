<?php
namespace App\Core;

class Session{

    public static function start() :void{
        session_start();
    }

    public static function addMessage(array $messages){
        
        foreach($messages as $message){
            $_SESSION['message'][] = $message;
        }

    }

    public static function getMessage(){
        return $_SESSION['message'];
    }

    public static function clearMessage(){
        $_SESSION['message'] = [];
    }

}