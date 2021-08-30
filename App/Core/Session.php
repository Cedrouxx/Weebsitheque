<?php
namespace App\Core;

class Session{

    public static function start() :void{
        session_start();
    }

    public static function addMessage(array $messages): void{
        
        foreach($messages as $message){
            $_SESSION['message'][] = $message;
        }

    }

    public static function getMessage(): array{
        return $_SESSION['message'] ?? [];
    }

    public static function clearMessage(): void{
        $_SESSION['message'] = [];
    }

    public static function login(int $userId, string $username, string $userEmail, bool $isAdmin): void{
        $_SESSION['user'] = [
            'id' => $userId,
            'username' => $username,
            'email' => $userEmail,
            'isAdmin' => $isAdmin
        ];
    }

    public static function logout(): void{
        unset($_SESSION['user']);
    }

    public static function isLogin(): bool{
        return !empty(Session::getUser());
    }

    public static function getUser() :array{
        return $_SESSION['user'] ?? [];
    }

}