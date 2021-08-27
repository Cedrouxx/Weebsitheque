<?php

namespace App\Model;

use App\Core\Database;
use PDO;
use PDOStatement;

class Model extends Database{

    private function dataFormater(array $data) :array{
        $champsName = implode(',', array_keys($data));
        $paramsName = [];
        foreach(array_keys($data) as $paramName ){
            $paramsName[] = ':'.$paramName;
        }
        $paramsName = implode(',', $paramsName);

        return [
            'champsName' => $champsName,
            'paramsName' => $paramsName
        ];
    }

    private function autoBindValue(PDOStatement $query, string $param, string $value){

        if(is_int($value))
            $query->bindValue(':'.$param, $value , PDO::PARAM_INT);
        else if(is_bool($value))
            $query->bindValue(':'.$param, $value , PDO::PARAM_BOOL);
        else
            $query->bindValue(':'.$param, $value , PDO::PARAM_STR);


        return $query;
    }

    private function secure(array $datas): array{

        $result = [];
        foreach($datas as $key => $data){
            if(ctype_digit($data)) $result[$key] = intval($data);
            else if(is_numeric($data)) $result[$key] = floatval($data);
            else $result[$key] = htmlspecialchars($data);
        }
        return $result;
    }

    protected function get(string $from, array $data, string $where = '1'): array{
        
        $champsName = implode(',', $data);

        $sql =  'SELECT 
                    '.$champsName.'
                FROM 
                    '.$from.'
                WHERE
                    '.$where;
        
        $query = $this->pdo->prepare($sql);

        $query->execute(); 
        
        return $this->secure(($query->fetchAll(PDO::FETCH_ASSOC)) ?:  []);
    }

    protected function getOne(string $from, array $data, WhereMaker $where): array{
        
        $champsName = implode(',', $data);

        $sql =  'SELECT 
                    '.$champsName.'
                FROM 
                    '.$from.'
                WHERE
                    '.$where->getInCommand();
        
        $query = $this->pdo->prepare($sql);
        
        for($i = 0; $i < count($where->getChampNames()); $i++){

            //$query = $this->autoBindValue($query ,$where->getChampNames()[$i], $where->getValues()[$i]);

            if(is_int($where->getValues()[$i]))
                $query->bindValue(':'.$where->getChampNames()[$i], $where->getValues()[$i] , PDO::PARAM_INT);
            else if(is_bool($where->getValues()[$i]))
                $query->bindValue(':'.$where->getChampNames()[$i], $where->getValues()[$i] , PDO::PARAM_BOOL);
            else
                $query->bindValue(':'.$where->getChampNames()[$i], $where->getValues()[$i] , PDO::PARAM_STR);

        }

        $query->execute();
        
        return $this->secure(($query->fetch(PDO::FETCH_ASSOC)) ?:  []);
    }

    protected function insert(string $from, array $data){

        $dataFormated = $this->dataFormater($data);

        $sql = 'INSERT INTO 
                    '.$from.'('.$dataFormated['champsName'].') 
                VALUES 
                    ('.$dataFormated['paramsName'].')';

        $query = $this->pdo->prepare($sql);

        foreach($data as $key => $value){
            
            $query = $this->autoBindValue($query ,$key, $value);

        }

        $query->execute(); 

        
    }

}