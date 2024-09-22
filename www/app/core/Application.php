<?php
namespace app\core;
use app\core\Response;

class Application{

    public static Application $app;
    public static string $rootDIR;

    private Router $router;
    public Response $response;

    public function __construct(string $rootPath){

        self::$app = $this;
        self::$rootDIR = $rootPath;

        $this->router = new Router();
        $this->response = new Response();
    }

    /**
     * Lance l'application
     *
     * @return [type]
     * 
     */
    public function run(){

        echo $this->router->resolve();
    }

}