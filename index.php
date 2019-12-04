<?php
//TODO SESSION START LOGIN
// ADMIN PANEL AVATAR IMAGE
session_start();
//var_dump($_SESSION);

define(ROOT_FOLDER, filter_var($_SERVER['DOCUMENT_ROOT']));
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]"));

class Router
{

    private $_controller;
    private $_view;
    private static $_errorLog = [];

    public static function addToErrorLog() {
        $addToLog = static::$_errorLog; //html special char
        if (static::$_errorLog !== $addToLog) {
            $addToLog .= 'NOT SAME';
        }
        View::addErrorLog($addToLog);
    }

    public function routerQuery()
    {
        static::$_errorLog .= '<br/>ROUTER <br/>';

        //var_dump($_SESSION['level']);
        try {
            // Chargement automatique des models/classes
            spl_autoload_register(static function($className) {

                static::$_errorLog .= 'CLASS => ' . $className . '<br/>';

                $classTest1 = 'Model';
                $classTest2 = 'View';
                $classTest3 = 'Controller';
                $classTest4 = 'PostTemplate';
                $classTest5 = 'Template';
                $classTest6 = 'Post';
                $classTest7 = 'Manager';
                $classTests = '/(' . $classTest1 . '|' . $classTest2 . '|' . $classTest3 . '|' . $classTest4 . '|' . $classTest5 . '|' . $classTest6 . '|' . $classTest7 . ')/';
                preg_match($classTests, $className, $classMatch);

                static::$_errorLog .= 'classMatch => ' . $classMatch[1] . '<br/>';

                if ($classMatch[1] === $classTest4 || $classMatch[1] === $classTest5) {
                    $strReplace = 'Views/Templates';
                } elseif ($classMatch[1]=== $classTest6 || $classMatch[1] === $classTest7) {
                    $strReplace = 'Models';
                } else {
                    $strReplace = $classMatch[1] . 's';
                }

                static::$_errorLog .= 'CLASSPATH => ' . ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php END' . '<br/>';
                require_once(ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php');

            });

            if (isset($_GET['url'])) {
                // Decoupe et filtrage de l'url / des actions
                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                [$mainFolder, $subFolder] = $url;
                static::$_errorLog .= 'MainFolder => ' . $mainFolder . '<br/>';
                static::$_errorLog .= 'SubFolder => ' . $subFolder . '<br/>';
                static::$_errorLog .= 'Query String => ' . $_SERVER['QUERY_STRING'] . '<br/>';
                static::$_errorLog .= 'form => ' . $_GET['submit'] . '<br/>';

                $controllerName = 'Controller' . $mainFolder;
                $this->_controller = new $controllerName($subFolder);
            } else {
                $this->_controller = new ControllerHome(null);
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage() . '<pre>' . print_r(static::$_errorLog) . '</pre>';
            $this->_view = new ViewError;
            $this->_view->generate(array('errorMsg' => $errorMsg));
        }
    }
}
$mainRouter = new Router();
$mainRouter->routerQuery();

Router::addToErrorLog();
View::showErrorLog();


