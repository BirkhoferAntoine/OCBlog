<?php
session_start();
// u95785354
define('ROOT_FOLDER', __DIR__);
define('URL', str_replace('index.php', '', (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_URL) . filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_URL)));

require_once(ROOT_FOLDER . '/Controllers/ControllerSecurity.php');
$security = new ControllerSecurity(
    array(
        'url'           =>    FILTER_SANITIZE_URL,
        'submit'        =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'editor'        =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'post'          =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'comment'      =>    FILTER_SANITIZE_STRING,
        'comments'      =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'flag'          =>    FILTER_SANITIZE_STRING,
        'accept'        =>    FILTER_VALIDATE_INT,
        'edit'          =>    FILTER_VALIDATE_INT,
        'delete'        =>    FILTER_VALIDATE_INT,
        'listrange'     =>    FILTER_VALIDATE_INT,
        'logout'       =>    FILTER_SANITIZE_STRING,
        'logedin'       =>    FILTER_SANITIZE_STRING
    ),
    array(
        'commentEditor'                 =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'register_user_name'            =>    FILTER_SANITIZE_STRING,
        'register_user_email'           =>    FILTER_SANITIZE_EMAIL,
        'register_password'             =>    FILTER_SANITIZE_STRING,
        'register_confirm_password'     =>    FILTER_SANITIZE_STRING,
        'login_identifier'              =>    FILTER_SANITIZE_EMAIL,
        'login_password'                =>    FILTER_SANITIZE_STRING,
        'user'                          =>    FILTER_SANITIZE_STRING,
        'commentUser'                   =>    FILTER_SANITIZE_STRING,
        'flag'                          =>    FILTER_VALIDATE_INT,
        'accept'                        =>    FILTER_VALIDATE_INT,
        'edit'                          =>    FILTER_VALIDATE_INT,
        'delete'                        =>    FILTER_VALIDATE_INT,
        'postId'                        =>    FILTER_VALIDATE_INT,
        'postTitle'                     =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postText'                      =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postContent'                   =>    FILTER_SANITIZE_STRING | FILTER_FLAG_NO_ENCODE_QUOTES,
        'postUrlImage'                  =>    FILTER_SANITIZE_URL
    )
);

class Router
{
    private        $_controller;
    private        $_view;
    private        $_safeGet;
    private        $_safeUri;

    public function __construct()
    {
        $this->_setSecurity();
        $this->_routerQuery();
    }

    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
        $this->_safeUri = $security->getFilteredUri();
        //TODO REMOVE
       /* print_r($this->_safeUri);
        print_r($this->_safeGet);*/
    }

    private function _routerQuery()
    {

        try {
            // Chargement automatique des models/classes
            spl_autoload_register(static function($className) {

                $classTest1 = 'Model';
                $classTest2 = 'View';
                $classTest3 = 'Controller';
                $classTest4 = 'PostTemplate';
                $classTest5 = 'Template';
                $classTest6 = 'Post';
                $classTest7 = 'Manager';
                $classTests = '/(' . $classTest1 . '|' . $classTest2 . '|' . $classTest3 . '|' . $classTest4 . '|' . $classTest5 . '|' . $classTest6 . '|' . $classTest7 . ')/';
                preg_match($classTests, $className, $classMatch);

                if ($classMatch[1] === $classTest4 || $classMatch[1] === $classTest5) {
                    $strReplace = 'Views/Templates';
                } elseif ($classMatch[1]=== $classTest6 || $classMatch[1] === $classTest7) {
                    $strReplace = 'Models';
                } else {
                    $strReplace = $classMatch[1] . 's';
                }

                $filePath = ROOT_FOLDER . '/' . $strReplace . '/' . $className . '.php';
                if (file_exists($filePath)) {
                    require_once($filePath);
                } else {
                    throw new Exception('Fichier ' . $className . 'introuvable');
                }
            });

            if (isset($this->_safeGet['url'])) {
                // Decoupe et filtrage de l'url / des actions
                $url = explode('/', $this->_safeGet['url']);
                [$mainFolder, $subFolder] = $url;

                $controllerName = 'Controller' . $mainFolder;
                $this->_controller = new $controllerName($subFolder);
            } else {
                $this->_controller = new ControllerHome(null);
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            $this->_view = new ViewError;
            $this->_view->generate(array('errorMsg' => $errorMsg));
        }
    }
}


$main = new Router();

//TODO DEL ERRORLOG, DEL OLD FILES


