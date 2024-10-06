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

        if (!isset($_SERVER["REQUEST_URI"])) { return null; }

        $url = $_SERVER["REQUEST_URI"];
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return explode('/', $url);
    }

    public static function getURLController() : mixed{

        $url = self::getURL();

        return isset($url[1]) ? $url[1] : null;
    }
    public static function getURLMethod() : mixed{

        $url = self::getURL();
        return isset($url[2]) ? $url[2] : null;
    }
}