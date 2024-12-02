<?php

class Router {
    // Visibilité des props et methods
    // private : on accède à la props ou la method seulement depuis l'intérieur de la class
    // protected : on accède à la props ou la method seulement depuis l'intérieur de la class et des classes enfants
    // public : on accède à la props ou la method depuis l'intérieur de la class et des classes enfants
    private $currentController = 'Pages';
    private $currentMethod = 'index';
    private $params = [];

    public function __construct() {
        // récupérer l'url
        $url = $this->getUrl();

        // récupérer le premier param de l'url et on défini le controller courant
        if (!empty($url) && isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        // récupérer et instancier le controller courant
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // vérifier le deuxième param de l'url et récupérer la méthode du controller
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // vérifier le troisième param de l'url et récupérer les params
        // on vérifie si l'url contient des params sinon on met le tableau vide
        // array_values() permet de réindexer le tableau
        $this->params = $url ? array_values($url) : [];

        // Appeler le controller + méthode + param en fonction de ce qui est défini dans l'url
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    //fonction qui récupère l'url et la sécurisé
    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}