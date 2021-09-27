<?php

namespace App\Model;

use App\Core\Database;
use PDO;

class Orm extends Database{

    private array $select = [];
    private string $from = '';
    private array $values = [];
    private array $with = [];
    private array $where = [];
    private string $groupBy = '';
    private array $orderBy = [];

    /* secure the datas */
    private function secure(array $datas): array{

        $result = [];
        foreach($datas as $key => $data){
            if(ctype_digit($data)) $result[$key] = intval($data);
            else if(is_numeric($data)) $result[$key] = floatval($data);
            else $result[$key] = htmlspecialchars($data);
        }
        return $result;
    }

    /* call secure for all datas */
    private function secureAll(array $datas): array{
        $newDatas = [];
        foreach($datas as $data){
            $newDatas[] = $this->secure($data);
        }
        return $newDatas;
    }

    /* reset object */
    private function reset(): void{
        $this->select = [];
        $this->from = '';
        $this->where = [];
        $this->with = [];
        $this->orderBy = [];
        $this->values = [];
    }
    
    /* set the SELECT */
    public function select(string ...$select): Orm{
        $this->select = $select;
        return $this;
    }

    /* set the FROM */
    public function from(string $from): Orm{
        $this->from = $from;
        return $this;
    }

    /* add WHERE */
    public function where(string $champName, $value): Orm{
        $this->where[] = [
            'champName' => $champName,
            'value' => $value
        ];
        return $this;
    }

    /* set the GROUP BY */
    public function groupBy(string $groupBy): Orm{
        $this->groupBy = $groupBy;
        return $this;
    }

    /* add join */
    public function with(string $table, string $first_id, string $second_id, string $typeJoin = 'INNER'): Orm{
        $this->with[] = [
            'table' => $table,
            'first_id' => $first_id,
            'second_id' => $second_id,
            'type' => strtoupper($typeJoin)
        ];
        return $this;
    }

    /* set ORDER BY */
    public function orderBy(string ...$orderBy): Orm{
        $this->orderBy = $orderBy;
        return $this;
    }

    /* set values for UPDATE and INSERT */
    public function values(array $values): Orm{
        $this->values = $values;
        return $this;
    }

    /* make the sql command */
    private function get(): \PDOStatement{

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

    /* get several element */
    public function getAll(): array{
        $query = $this->get();
        return ModelOutput::makeAll($this->secureAll(($query->fetchAll(PDO::FETCH_ASSOC)) ?:  []));
    }

    /* get one element */
    public function getOne(): ModelOutput{
        $query = $this->get();
        return ModelOutput::makeOne($this->secureAll(( $query->fetchAll(PDO::FETCH_ASSOC)) ?:  []));
    }

    /* make and execute command INSERT */
    public function insert(): void{

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

    /* make and execute command UPDATE */
    public function update(): void{

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

    /* make and exectute command DELETE */
    public function delete(): void{

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