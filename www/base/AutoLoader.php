<?php

namespace base;
Autoloader::register();

class AutoLoader{

    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){

        $class = __DIR__ .'/../'. str_replace('\\', '/', $class);
        require $class . '.php'; 
    }
}