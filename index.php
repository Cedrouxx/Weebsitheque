<?php

declare(strict_types = 1);


use App\Core\Session;
use App\Exception\LangException;
use Lang\Lang;

class Main{

    public function __construct(){
        
        $this->autoLoad();
        Session::start();
        define('config', require 'config.php');
        require 'helpers.php';

        $this->lang();

        new Router;

    }

    /* initializes the language */
    public function lang(): void{
        try{
            $lang = new Lang($_GET['lang'] ?? '');
            define('lang', $lang->getLang());
        }catch(LangException){
            if ($_GET['url'] === '')
                redirect($_GET['lang'] ?? '', 'fr');
            redirect('', 'fr');
        }
    }

    /* initializes the autoloader */
    public function autoLoad(): void{

        spl_autoload_register(function ($class_name) {
            include str_replace('\\', '/', $class_name) . '.php';
        });

    }

}
new Main();