<?php
namespace app\core;
use InvalidArgumentException;

class Router{

    use traits\applyLayout;
    use traits\applyControllers;
    use traits\applyLib;

    protected $controller = 'home';
    protected $method = 'index';

    private array $loadedCSS = array();
    private array $loadedJS = array();
    private array $loadedLib = array();

    public function resolve(){

        $urlController = Request::getURLController()??$this->controller;
        $urlMethod = Request::getURLMethod()??$this->method;

        $isHttpRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']);
        $isAjax = $isHttpRequest && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if(file_exists(Application::$rootDIR .'/app/controllers/'. $urlController .'.php')){

            $this->controller = $urlController;

            $class = '\\app\\controllers\\' . $this->controller;
            $this->controller = new $class();
            $this->method = $isAjax ? 'ajax_'. $urlMethod : $urlMethod;

            if(method_exists($this->controller, $this->method)){

                call_user_func([$this->controller, $this->method]);
                return  $isAjax ? '' : $this->renderView($this->controller);
            }
        }

        Application::$app->response->setStatusCode(404);
        return $this->renderOnlyView("_404");
    }

    /**
     * Permet de rendre la View
     *
     * @param string $view
     *
     * @return mixed
     *
     */
    private function renderView(mixed $controller){

        $fullView = $this->layoutContent();
        $viewContent = $this->renderOnlyView($controller->getview());

        $fullView = str_replace("{{content}}", $viewContent, $fullView);
        $fullView = $this->applyControllers($fullView, $controller);
        $fullView = $this->applyLayout($fullView);
        $fullView = $this->applyLib($fullView);

        $this->clearView($fullView);

        return $fullView;
    }

    /**
     * Supprime tout les {{__}} de la view
     *
     * @param string $fullView
     *
     * @return string
     *
     */
    private function clearView(string &$fullView) : string{

        $pattern = '!\{\{(.*)\}\}!';

        preg_match_all($pattern, $fullView, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $val) {

            $fullView = str_replace($val[0], '', $fullView);
        }

        return $fullView;
    }

    /**
     * Permet de remplacer la balise par les elements du tableau en fonction du type
     *
     * @param string $balise
     * @param array $css
     * @param string $fullView
     * @param string $type
     *
     * @return string
     *
     */
    private function apply(string $balise, array $array, string $fullView, string $type, string $lib=null) : string{

        $link = '';

        if (is_null($lib)) { $root = "/public"; }
        else { $root = "/public/lib/$lib"; }

        foreach ($array as $element) {
            
            if ($type == 'css') { $fullRoot = "$root/css"; }
            elseif ($type == 'js') { $fullRoot = "$root/js"; }

            if (file_exists(Application::$rootDIR . "$fullRoot/$element.$type")) {

                if ($type == 'css') {

                    if (in_array($element, $this->loadedCSS)) { continue; }

                    $link .= "<link rel='stylesheet' type='text/css' href=$fullRoot/$element.css />";
                    array_push($this->loadedCSS, $element);
                }
                elseif ($type == 'js') {

                    if (in_array($element, $this->loadedJS)) { continue; }

                    $link .= "<script src=$fullRoot/$element.js /></script>";
                    array_push($this->loadedJS, $element);
                }

                continue;
            }

            throw new InvalidArgumentException("Le $type $element n'existe pas !");
        }

        return str_replace($balise, $link, $fullView);
    }

    private function renderOnlyView($view) : string{

        ob_start();
        include_once Application::$rootDIR . "/app/views/$view/$view.php";
        return ob_get_clean();
    }
    private function layoutContent() : string{
       
        ob_start();
        include_once Application::$rootDIR . "/app/views/layout/layout.php";
        return ob_get_clean();

    }
}