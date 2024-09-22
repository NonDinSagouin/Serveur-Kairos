<?php
namespace app\core\traits;
use InvalidArgumentException;

trait applyLib{

    /**
     * Permet le chargement du CSS et du JS d'une librairie public/lib/
     *
     * @param string $lib
     * @param string $fullView
     *
     * @return null
     *
     */
    private function addLib(string $lib){

        if (!is_dir("public/lib/$lib")) {
            throw new InvalidArgumentException("La librairie $lib introuvable dans public/lib/ !");
        }
        if (!file_exists("public/lib/$lib/conf.ini")) {
            throw new InvalidArgumentException("Le conf.ini de la librairie $lib introuvable dans public/lib/$lib/ !");
        }
        if (array_key_exists($lib, $this->loadedLib)) {
            throw new InvalidArgumentException("Attention $lib est déjà chargé !");
        }

        $conf = parse_ini_file("public/lib/$lib/conf.ini");

        $this->loadedLib[$conf['LIB_NAME']] = array(
            'LIB_CSS' => $conf['LIB_CSS'],
            'LIB_JS' => $conf['LIB_JS']
        );
    }
    /**
     * Permet l'application des données chargées pour les librairies
     *
     * @param string $fullView
     *
     * @return string
     *
     */
    private function applyLib(string $fullView) : string{

        $fullView = $this->applyPlaceholer($fullView);

        foreach ($this->loadedLib as $name => $lib) {

            $layerCSS = $lib['LIB_CSS'];
            $layerJS = $lib['LIB_JS'];

            $css = $layerCSS != '' ? explode(',', $layerCSS) : null;
            $js = $layerJS != '' ? explode(',', $layerJS) : null;

            if (!is_null($css)) {
                $fullView = $this->apply("{{". $name ."CSS}}", $css, $fullView, 'css', $name);
            }
            if (!is_null($js)) {
                $fullView = $this->apply("{{". $name ."JS}}", $js, $fullView, 'js', $name);
            }
        }

        return $fullView;
    }

    /**
     * Permet de remplacer les placeholder lib par placeholder des librairies
     *
     * @param string $fullView
     *
     * @return string
     *
     */
    private function applyPlaceholer(string $fullView) : string{

        $cssLib = "";
        $jsLib = "";

        foreach ($this->loadedLib as $name => $lib) {

            $cssLib .= "{{" . $name . "CSS}}";
            $jsLib .= "{{" . $name . "JS}}";
        }

        $fullView = str_replace("{{libCSS}}", $cssLib, $fullView);
        $fullView = str_replace("{{libJS}}", $jsLib, $fullView);

        return $fullView;
    }
}