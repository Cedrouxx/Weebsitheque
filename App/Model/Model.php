<?php

namespace model;

use core\Database;
use PDO;

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

    protected function getAll(string $from, array $data): array{
        
        $champsName = implode(',', $data);

        $sql =  'SELECT 
                    '.$champsName.'
                FROM 
                    '.$from;
        
        $query = $this->pdo->prepare($sql);

        $query->execute(); 
        
        return ($query->fetchAll(PDO::FETCH_ASSOC)) ?:  [];
    }

}