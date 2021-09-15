<?php

namespace App\Model;

use App\Core\Database;
use PDO;
use PDOStatement;

class Orm extends Database{

    private array $select = [];
    private string $from = '';
    private array $values = [];
    private array $with = [];
    private array $where = [];
    private string $groupBy = '';
    private array $orderBy = [];

    private function secure(array $datas): array{

        $result = [];
        foreach($datas as $key => $data){
            if(ctype_digit($data)) $result[$key] = intval($data);
            else if(is_numeric($data)) $result[$key] = floatval($data);
            else $result[$key] = htmlspecialchars($data);
        }
        return $result;
    }

    private function secureAll(array $datas): array{
        $newDatas = [];
        foreach($datas as $data){
            $newDatas[] = $this->secure($data);
        }
        return $newDatas;
    }

    private function reset(){
        $this->select = [];
        $this->from = '';
        $this->where = [];
        $this->with = [];
        $this->orderBy = [];
        $this->values = [];
    }
    
    public function select(string ...$select){
        $this->select = $select;
        return $this;
    }

    public function from(string $from){
        $this->from = $from;
        return $this;
    }

    public function where(string $champName, $value){
        $this->where[] = [
            'champName' => $champName,
            'value' => $value
        ];
        return $this;
    }

    public function groupBy(string $groupBy){
        $this->groupBy = $groupBy;
        return $this;
    }

    public function with(string $table, string $first_id, string $second_id, string $typeJoin = 'INNER'){
        $this->with[] = [
            'table' => $table,
            'first_id' => $first_id,
            'second_id' => $second_id,
            'type' => strtoupper($typeJoin)
        ];
        return $this;
    }

    public function orderBy(string ...$orderBy){
        $this->orderBy = $orderBy;
        return $this;
    }

    public function values(array $values){
        $this->values = $values;
        return $this;
    }

    private function get(){

        $select = 'SELECT '.(!empty($this->select)? implode(',', $this->select) : '*');

        $from = 'FROM '.$this->from;

        $withTable = [];
        foreach($this->with as $value){
            $withTable[] = 
                $value['type'].' JOIN '.$value['table'].'
                ON '.$value['first_id'].' = '.$value['second_id'].'
            ';
        }
        $with = implode(' ', $withTable);

        $whereCommand = [];
        foreach($this->where as $value){
            $whereCommand[] = $value['champName'].' = ?';
        }
        $where = 'WHERE '.(!empty($this->where)? implode(' AND ', $whereCommand) : '1');

        $groupBy = '';
        if (!empty($this->groupBy))
            $groupBy = 'GROUP BY '.$this->groupBy;

        $orderBy = !empty($this->orderBy) ? 'ORDER BY '.implode(',', $this->orderBy) : '';

        
        $sql = $select.' '.$from.' '.$with.' '.$where. ' '.$groupBy.' '.$orderBy;
        $query = $this->pdo->prepare($sql);


        for($i = 0; $i<count($this->where); $i++){
            $query->bindValue($i+1, $this->where[$i]['value']);
        }

        $query->execute();

        $this->reset();

        return $query;
        
    }

    public function getAll(){
        $query = $this->get();
        return ModelOutput::makeAll($this->secureAll(($query->fetchAll(PDO::FETCH_ASSOC)) ?:  []));
    }

    public function getOne(){
        $query = $this->get();
        return ModelOutput::makeOne($this->secureAll(( $query->fetchAll(PDO::FETCH_ASSOC)) ?:  []));
    }

    public function insert(){

        $from = 'INSERT INTO '.$this->from;

        $champsName = implode(',', array_keys($this->values));
        $bindTable = [];
        foreach($this->values as $value){
            $bindTable[] = '?';
        }
        $bind = implode(',', $bindTable);

        $sql = $from.'('.$champsName.') VALUES ('.$bind.')';
        $query = $this->pdo->prepare($sql);

        $justValue = array_values($this->values);

        for($i = 0; $i<count($justValue); $i++){
            $query->bindValue($i+1, $justValue[$i]);
        }

        $query->execute(); 

        $this->reset();
    }

    public function update(){

        $from = 'UPDATE '.$this->from;

        $champsNamesTable = [];
        foreach(array_keys($this->values) as $value){
            $champsNamesTable[] = $value.' = ? ';
        }
        $champsNames = implode(',', $champsNamesTable);

        $whereCommand = [];
        foreach($this->where as $value){
            $whereCommand[] = $value['champName'].' = ?';
        }
        $where = 'WHERE '.(!empty($this->where)? implode(' AND ', $whereCommand) : '1');

        $sql = $from.' SET '.$champsNames.' '.$where;
        $query = $this->pdo->prepare($sql);

        $justValue = array_values($this->values);

        for($i = 0; $i<count($justValue); $i++){
            $query->bindValue($i+1, $justValue[$i]);
        }

        for($o = 0; $o<count($this->where); $o++){
            $query->bindValue($o+1+$i, $this->where[$o]['value']);
        }

        $query->execute(); 

        $this->reset();
    }

    public function delete(){

        $from = 'DELETE FROM '.$this->from;

        $whereCommand = [];
        foreach($this->where as $value){
            $whereCommand[] = $value['champName'].' = ?';
        }
        $where = 'WHERE '.(!empty($this->where)? implode(' AND ', $whereCommand) : '1');

        $sql = $from.' '.$where;
        $query = $this->pdo->prepare($sql);

        for($o = 0; $o<count($this->where); $o++){
            $query->bindValue($o+1, $this->where[$o]['value']);
        }

        $query->execute(); 

        $this->reset();
    }

}