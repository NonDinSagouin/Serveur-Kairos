<?php
namespace app\core\traits;
use ErrorException;

trait applyControllers{

    /**
     * Permet l'appilcation des CSS ou JS demandés pas les controllers
     *
     * @param string $fullView
     * @param mixed $controller
     *
     * @return string
     *
     */
    private function applyControllers(string $fullView, mixed $controller) : string{

        $fullView = $this->apply("{{linkCSS}}", $controller->getcss(), $fullView, 'css');
        $fullView = $this->apply("{{linkJS}}", $controller->getjs(), $fullView, 'js');

        return $fullView;
    }
    
}