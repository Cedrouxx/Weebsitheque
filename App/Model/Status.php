<?php

namespace App\Model;

class Status extends Model{

    public function getAllStatus(): array{

        return $this->select('name', 'id')
        ->from('user_list_status')
        ->getAll();

    }

}