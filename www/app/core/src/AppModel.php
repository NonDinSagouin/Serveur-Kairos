<?php

namespace app\core\src;

use mysqli;

class AppModel{

    /**
     * Permet de définire le connecteur BDD
     *
     * @return mysqli
     *
     */
    protected static function dbConnecteur() : mysqli{

        $servername = getenv('DATABASE_HOST');
        $username = getenv('DATABASE_USER');
        $password = getenv('DATABASE_PASSWORD');
        $db = getenv('DATABASE_NAME');
        
        return mysqli_connect($servername, $username, $password, $db);
    }

    /**
     * Créer la commande de base avec les placeholder
     *
     * @return string
     *
     */
    protected static function commande() : string{

        return "
            SELECT
                {{select}}
            FROM
                {{from}}
            
            {{options}}
        ";
    }

    protected static function applySelect(mixed $select, string $commande) : string{

        $return = "";
        $placeHolder = "{{select}}";

        if (is_array($select)){
            return self::applyArray($placeHolder, __METHOD__, $select, $commande);
        }

        if ($select == 'all'){
            $return = str_replace($placeHolder, "*", $commande);
        }
        elseif ($select == 'first'){
            $return = str_replace($placeHolder, "top(1) *", $commande);
        }
        else{
            $return = str_replace($placeHolder, "$select", $commande);
        }

        return $return;
    }
    protected static function applyFrom(string $actualClass, string $commande) : string{

        $split = explode('\\', $actualClass);
        $class = end($split);
        $str = getenv('DATABASE_NAME') . "." . $class;

        return str_replace("{{from}}", self::completerStr($str), $commande);
    }

    protected static function applyWhere(mixed $where, string $commande) : string{

        if (is_null($where)){
            return str_replace("{{options}}", '', $commande);
        }
            
        $str = 'WHERE/br/{{where}}';
        $str = self::applyArray( "{{where}}",  __METHOD__, $where, $str);
        $str = self::completerStr($str);

        return str_replace("{{options}}", $str, $commande);
    }

    private static function applyArray(string $placeholder, string $method, array $array, string $commande) : string {

        $str = '';
        $split = explode('::', $method);
        $method = end($split);

        $i = 0;
        $max = count($array) -1;

        foreach ($array as $key => $value) {

            if($method == 'ApplySelect'){

                if ($key == $max) { $str .= $value .'/br/'; }
                else { $str .= $value .',/br/'; }
                continue;
            }
            if($method == 'ApplyWhere'){

                if (!is_numeric($value) && !str_contains($key, ' between')) { $value = '\'' . $value . '\''; }
                if ($i > 0) { $str .= "/br/AND "; }
                $str .= $key .' '. $value;

                $i++;
            }
        }

        return str_replace($placeholder, self::completerStr($str), $commande);
    }

    private static function completerStr(string $str) : string{

        $str = str_replace("/br/", '
                ', $str);

        return $str;
    }

}