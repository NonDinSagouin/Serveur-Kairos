<?php
namespace app;
use app\core\Application;

class Init{

    public Application $application;

    public static function startApplication(string $rootPath){
        
        $application = new Application($rootPath);
        $application->run();
    }

}