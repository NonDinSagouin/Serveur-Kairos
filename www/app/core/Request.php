<?php
namespace app\core;

class Request{

    /**
     * Retourne le chemin URL
     *
     * @return mixed
     *
     */
    private static function getURL() : mixed{

        if (!isset($_GET['url'])) { return null; }

        $url = $_GET['url'];
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return explode('/', $url);
    }

    public static function getURLController() : mixed{

        $url = self::getURL();

        return isset($url[0]) ? $url[0] : null;
    }
    public static function getURLMethod() : mixed{

        $url = self::getURL();
        return isset($url[1]) ? $url[1] : null;
    }
}