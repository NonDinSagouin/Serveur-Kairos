<?php
namespace app\core\src;

class AppController{

    /**
     * Les views qui seront chargées
     *
     * @var string
     */
    protected string $view;
    /**
     * Les CSS qui seront chargés
     *
     * @var array
     */
    protected array $css;
    /**
     * Les JS qui seront chargés
     *
     * @var array
     */
    protected array $js;



    /**
     * Récupère la valeur des views
     */
    public function getView(){
        return $this->view;
    }

    /**
     * Récupère la valeur des css
     */
    public function getCss(){
        return $this->css;
    }

    /**
     * Récupère la valeur des js
     */
    public function getJs(){
        return $this->js;
    }
}