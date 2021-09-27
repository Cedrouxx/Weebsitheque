<?php

namespace Lang;

use App\Exception\LangException;

class lang {

    public ?array $lang;

    public function __construct(string $lang){

        $file = file_get_contents('Lang/'.$lang.'.json');
        $lang = json_decode($file, true);
        if(!$lang)
            throw new LangException('Langage not found !');
        else
            $this->lang = $lang;
    }

    public function getLang(): array{
        return $this->lang;
    }

}