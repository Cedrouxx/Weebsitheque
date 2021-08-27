<?php
namespace core;

use PDO;
use PDOException;

class Database{

    private array $config;

    private string $server;
    private string $user;
    private string $password;
    private array $options;
    public PDO $pdo;
    
    public function __construct(){
        
        $this->config = require 'config.php';

        $this->server   = 'mysql:host='.$config['database']['host'].';dbname='.$config['database']['name'];
        $this->user     = 'root';
        $this->password = '';
        $this->options  = [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'  
                        ];
                        
        $this->pdo = $this->connexion();
    }
    
    
    
    public function connexion() :PDO{
        
       try {
            return new PDO($this->server,$this->user,$this->password,$this->options);
                                
        } catch (PDOException $e) {
                
            echo $e;
            die();
    
        } 
        
        
    }

}