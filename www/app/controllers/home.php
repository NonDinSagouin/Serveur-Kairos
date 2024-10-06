<?php

namespace app\controllers;

use app\core\src\AppController;

class Home extends AppController{

    public function index(){

        $this->view = "home";
        $this->css = ["home"];
        $this->js = [];
    }
}