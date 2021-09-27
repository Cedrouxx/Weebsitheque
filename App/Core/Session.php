<?php
namespace App\Core;

class Session{

    /* start session */
    public static function start() :void{
        session_start();
    }

    /* add message */
    public static function addMessage(array $messages): void{
        
        foreach($messages as $message){
            $_SESSION['message'][] = $message;
        }

    }

    /* return message */
    public static function getMessage(): array{
        return $_SESSION['message'] ?? [];
    }

    /* clear all message */
    public static function clearMessage(): void{
        $_SESSION['message'] = [];
    }

    /* login user */
    public static function login(int $userId, string $username, string $userEmail, string $image, bool $isAdmin): void{
        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
            'email' => $userEmail,
            'image' => $image,
            'isAdmin' => $isAdmin
        ];
    }

    /* logout user */
    public static function logout(): void{
        unset($_SESSION['user']);
    }

    /* if user is login */
    public static function isLogin(): bool{
        return !empty(Session::getUser());
    }

    /* get user info */
    public static function getUser() :array{
        return $_SESSION['user'] ?? [];
    }

}