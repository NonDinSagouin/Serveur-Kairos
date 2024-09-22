<?php

namespace app\controllers;

use app\core\src\AppController;
use app\models\test;
use src\Math;

class Home extends AppController{

    public function index(){

        $this->view = "home";
        $this->css = [];
        $this->js = [];
    }
}