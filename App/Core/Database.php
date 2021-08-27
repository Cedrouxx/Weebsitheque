<?php
namespace App\Core;

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

        $this->server   = 'mysql:host='.$this->config['database']['host'].';dbname='.$this->config['database']['name'];
        $this->user     = $this->config['database']['user'];
        $this->password = $this->config['database']['password'];
        $this->options  = $this->config['database']['option'];
                        
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