<?php

class Router {

    private $_controller;
    private $_view;

    public function routerQuery() {
        try {
            // Chargement automatique des models/classes
            spl_autoload_register(function($class){
                require_once('Models/' . $class . '.php');
            });

            $url = '';

            if (isset($_GET['url'])) {
                // Decoupe et filtrage de l'url / des actions
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                // Recherche les fichiers controlleurs
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = "Controller" . $controller;
                $controllerFile = "Controllers/" . $controllerClass . ".php";

                // Execute la classe controlleur inclue dans le fichier si il existe
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $this->_controller = new $controllerClass($url);
                } else {
                    throw new Exception('404 Page introuvable');
                }
            } else {
                require_once('Controllers/ControllerHome.php');
                $this->_controller = new ControllerHome($url);
            }
        }
        catch (Exception $e) {
            $errorMsg = $e -> getMessage();
            require_once('Views/viewError.php');
        }
    }
}

$homeRouter = new Router();
$homeRouter->routerQuery();
