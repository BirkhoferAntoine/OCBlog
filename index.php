<?php

define(ROOT_FOLDER, $_SERVER['DOCUMENT_ROOT']);
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
require_once(ROOT_FOLDER . '/Controllers/Controller.php');
require_once(ROOT_FOLDER . '/Views/View.php');

class Router
{

    private $_controller;
    private $_view;

    public function routerQuery()
    {
        try {
            // Chargement automatique des models/classes

            spl_autoload_register(function($className) {

                $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
                $classTest1 = 'Model';
                $classTest2 = 'View';
                $classTest3 = 'Controller';
                $classTest4 = 'Template';
                $strReplace = '';
                switch ($className){
                    case (strpos($className, $classTest1 === true)) :
                        $strReplace = $classTest1;
                        break;
                    case (strpos($className, $classTest2 === true)) :
                        $strReplace = $classTest2;
                        break;
                    case (strpos($className, $classTest3 === true)) :
                        $strReplace = $classTest3;
                        break;
                    case (strpos($className, $classTest4 === true)) :
                        $strReplace = '/Views/' . $classTest4;
                        break;
                }
                //$classFolder = str_replace("")
                require_once ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php';

            });
            $url = '';

            if (isset($_GET['url'])) {
                // Decoupe et filtrage de l'url / des actions
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

                // Recherche les fichiers controlleurs
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = 'Controller' . $controller;
                $controllerFile = 'Controllers/' . $controllerClass . '.php';

                // Execute la classe controlleur inclue dans le fichier si il existe
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $this->_controller = new $controllerClass($url);
                } else {
                    throw new Exception('404 Page introuvable');
                }
            } else {
                require_once(ROOT_FOLDER . '/Controllers/ControllerHome.php');
                $this->_controller = new ControllerHome($url);
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            $this->_view = new ViewError;
            $this->_view->generate(array('errorMsg' => $errorMsg));
        }
    }
}
$homeRouter = new Router();
$homeRouter->routerQuery();
