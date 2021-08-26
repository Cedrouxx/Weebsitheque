<?php

namespace App\Controller;

class ErrorController extends Controller{

    public function error404() :void{
        header('HTTP/1.0 404 Not Found');
        $this->lunchPage('errors/error404', 'Page non trouvé');
    }

}