<?php
namespace app\core\traits;
use InvalidArgumentException;

trait applyLayout{

    /**
     * Permet l'appilcation des CSS ou JS demandés pas les configurations du layout : conf/layout.ini
     *
     * @param string $fullView
     * 
     * @return string
     * 
     */
    private function applyLayout(string $fullView) : string {
        
        if (!file_exists('app/conf/layout.ini')){
            throw new InvalidArgumentException("Le layout.php introuvable dans app/conf/ !");
        }

        $confLayout = parse_ini_file('app/conf/layout.ini');

        $layerCSS = $confLayout['LAYER_CSS'];
        $layerJS = $confLayout['LAYER_JS'];
        $layerLIB = $confLayout['LAYER_LIB'];
        
        $css = $layerCSS != '' ? explode(',', $layerCSS) : null;
        $js = $layerJS != '' ? explode(',', $layerJS) : null;
        $lib = $layerLIB != '' ? explode(',', $layerLIB) : null;

        if (!is_null($css)) { $fullView = $this->apply("{{layoutCSS}}", $css, $fullView, 'css'); }
        if (!is_null($js)) { $fullView = $this->apply("{{layoutJS}}", $js, $fullView, 'js'); }
        
        foreach ($lib as $value) {
            $this->addLib($value);
        }

        return $fullView;
    }
    
}

?>