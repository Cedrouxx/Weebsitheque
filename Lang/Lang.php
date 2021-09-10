<?php

namespace Lang;

use App\Exception\LangException;

class lang {

    public ?array $lang;

    public function __construct(string $lang){

        $require = @include 'Lang/'.$lang.'.php';
        if(!$require)
            throw new LangException('Langage not found !');
        else
            $this->lang = $require;

    }

    public function getLang(): array{
        return $this->lang;
    }

}