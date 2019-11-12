<?php

define(ROOT_FOLDER, $_SERVER['DOCUMENT_ROOT']);
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

class Router
{

    private $_controller;
    private $_view;

    public static function getClassName($className) {

        $classTest1 = '(Model)';
        $classTest2 = '(^View)';
        $classTest3 = '(^Controller)';
        $classTest4 = '(Template)';
        $classTests = $classTest1 . $classTest2 . $classTest3 . $classTest4;
        print_r($classTests);
        $test = preg_match($classTests, $className, $result);
        print_r($test);
        print_r($result);
        /*switch ($className){
            case (strpos($className, $classTest1 === true)) :
                return $classTest1;
                break;
            case (strpos($className, $classTest2 === true)) :
                return $classTest2;
                break;
            case (strpos($className, $classTest3 === true)) :
                return $classTest3;
                print_r($className);
                break;
            case (strpos($className, $classTest4 === true)) :
                return 'Views/' . $classTest4;
                break;
            default : return '';
                break;
        }*/
    }

    public function routerQuery()
    {
        try {
            // Chargement automatique des models/classes

            spl_autoload_register(static function($className) {

                print_r($className);
                //$className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
                $classTest1 = 'Model';
                $classTest2 = 'View';
                $classTest3 = 'Controller';
                $classTest4 = 'Template';
                $classTest5 = 'Post';
                $classTests = '/(' . $classTest1 . '|' . $classTest2 . '|' . $classTest3 . '|' . $classTest4 . '|' . $classTest5 . ')/';
                print_r($classTests);
                preg_match($classTests, $className, $classMatch);
                if ($classMatch[1] === 'Post') {
                    print_r($classMatch[1]);
                    $strReplace = 'Models';
                } else {
                    $strReplace = $classMatch[1] . 's';
                }
                print_r($strReplace);

                //$classFolder = str_replace("")
                print_r(ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php END');
                require_once(ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php');

            });
            $url = '';

            if (isset($_GET['url'])) {
                // Decoupe et filtrage de l'url / des actions
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                print_r('u' . $url[0] . 'u');

                // Recherche les fichiers controlleurs
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = 'Controller' . $controller;
                $controllerFile = 'Controllers/' . $controllerClass . '.php';

                // Execute la classe controlleur inclue dans le fichier si il existe
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $this->_controller = new $controllerClass($url);
                } else {
                    throw new Exception('404 Page introuvable' . $controllerFile);
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
