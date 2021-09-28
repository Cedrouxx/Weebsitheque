<?php

namespace App\Controller;

class LangController extends Controller{

    // Change lang
    public function change(): void{
        if(!isset($_POST['lang']) || empty($_POST['lang'])){
            redirectToLastPage();
        }
        redirect($_POST['lastpage'], $_POST['lang']);
    }

}