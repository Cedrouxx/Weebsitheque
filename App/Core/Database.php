<?php
namespace App\Core;

use PDO;
use PDOException;

class Database{

    private string $server;
    private string $user;
    private string $password;
    private array $options;
    public PDO $pdo;
    
    public function __construct(){

        $this->server   = 'mysql:host='.config['database']['host'].';dbname='.config['database']['name'];
        $this->user     = config['database']['user'];
        $this->password = config['database']['password'];
        $this->options  = config['database']['option'];
                        
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