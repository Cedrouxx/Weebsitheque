<?php

namespace App\Model;

class WhereMaker{

    private string $inCommand;
    private array $champNames;
    private array $values;

    public function __construct(string $inCommand, array $champNames, array $values){

        foreach($champNames as $champName){
            $this->inCommand = str_replace('?', ':'.$champName, $inCommand);
        }

        $this->champNames = $champNames;
        $this->values = $values;

    }

    public function getInCommand(): string{
        return $this->inCommand;
    }

    public function getChampNames(): array{
        return $this->champNames;
    }

    public function getValues(): array{
        return $this->values;
    }

}