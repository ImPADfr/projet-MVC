<?php

class AbstractController{

    public function model($model) {
        // appel du model
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function render($view, $data = []) {
        $controllerName = strtolower(get_called_class());        
        // appel de la vue
        if (file_exists('../app/views/' . $controllerName . '/' . $view . '.php')) {
            require_once '../app/views/' . $controllerName . '/' . $view . '.php';
        } else {
            die('la vue ' . $view . ' n\'existe pas');
        }
    }
}

// class AbstractController {
//     // Définir les chemins de base pour les vues et modèles
//     protected $modelPath = __DIR__ . '/../models/';
//     protected $viewPath = __DIR__ . '/../views/';

//     public function model($model){
//         // Construction du chemin absolu vers le modèle
//         $modelFile = $this->modelPath . $model . '.php';
        
//         // Vérifier si le fichier du modèle existe avant de l'inclure
//         if (file_exists($modelFile)) {
//             require_once $modelFile;
//         } else {
//             die("Le modèle $model n'existe pas.");
//         }
        
//         // Instanciation du modèle
//         return new $model();
//     }

//     public function render($view, $data = []){
//         $controllerName = strtolower(get_called_class());

//         // Construction du chemin absolu vers la vue
//         $viewFile = $this->viewPath . $controllerName . '/' . $view . '.php';
        
//         // Vérifier si le fichier de la vue existe avant de l'inclure
//         if (file_exists($viewFile)) {
//             require_once $viewFile;
//         } else {
//             die("La vue $view n'existe pas dans le contrôleur $controllerName.");
//         }
//     }
// }