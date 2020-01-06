<?php
//TODO SESSION START LOGIN
session_start();
//var_dump($_SESSION);

define('ROOT_FOLDER', filter_var($_SERVER['DOCUMENT_ROOT'], FILTER_SANITIZE_URL));
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_URL) . filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_URL)));
require_once(ROOT_FOLDER . '/Controllers/ControllerSecurity.php');

class Router
{
    private        $_controller;
    private        $_view;
    private static $_errorLog = [];

    public function __construct()
    {
        $this->_routerQuery();
    }

    public static function addToErrorLog() {
        $addToLog = static::$_errorLog; //html special char
        if (static::$_errorLog !== $addToLog) {
            $addToLog .= 'NOT SAME';
        }
        View::addErrorLog($addToLog);
    }


    private function _routerQuery()
    {
        static::$_errorLog .= '<br/>ROUTER <br/>';

        //var_dump($_SESSION['level']);
        try {
            // Chargement automatique des models/classes
            spl_autoload_register(static function($className) {

                static::$_errorLog .= 'CLASS => ' . $className . '\n';

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

                $filePath = ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php';
                static::$_errorLog .= 'CLASSPATH => ' . $filePath . ' END' . '<br/>';
                if (file_exists($filePath)) {
                    require_once($filePath);
                } else {
                    throw new Exception('Fichier ' . $className . 'introuvable');
                }
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



$security = new ControllerSecurity(
    array(
        'submit'   =>    FILTER_SANITIZE_STRING,
        'editor'   =>    FILTER_SANITIZE_STRING,
        'post'     =>    FILTER_SANITIZE_STRING,
        'flag'            =>    FILTER_VALIDATE_INT,
        'accept'            =>    FILTER_VALIDATE_INT,
        'edit'            =>    FILTER_VALIDATE_INT,
        'delete'            =>    FILTER_VALIDATE_INT,
        'version'         =>    FILTER_SANITIZE_ENCODED
    ),
    array(
        'commentEditor'   =>    FILTER_SANITIZE_STRING,
        'register_user_name'   =>    FILTER_SANITIZE_EMAIL,
        'register_user_email'   =>    FILTER_SANITIZE_EMAIL,
        'register_password'   =>    FILTER_SANITIZE_STRING,
        'register_confirm_password'   =>    FILTER_SANITIZE_STRING,
        'login_identifier'   =>    FILTER_SANITIZE_EMAIL,
        'login_password'   =>    FILTER_SANITIZE_STRING,
        'flag'            =>    FILTER_VALIDATE_INT,
        'accept'            =>    FILTER_VALIDATE_INT,
        'edit'            =>    FILTER_VALIDATE_INT,
        'delete'            =>    FILTER_VALIDATE_INT,
        'postContent'   =>    FILTER_SANITIZE_STRING,
        'postUrlImage'   =>    FILTER_SANITIZE_URL
    )
);

$main = new Router();



Router::addToErrorLog();
// View::showErrorLog();


