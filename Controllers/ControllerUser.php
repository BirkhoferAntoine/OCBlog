<?php


class ControllerUser
{
    private $_usersManager;
    private $_view;
    private $_errorLog = [];

    public function __construct($url)
    {
        if (empty($url) || count($url) > 1) {
            throw new Exception('404 Page ' . htmlspecialchars($url) . ' introuvable');
        } else {
            // Decoupe et filtrage de l'url

            $this->_errorLog .= 'URL => ' . $url . '<br/>';

            $query = explode('&', $url);

            /*var_dump($_COOKIE);
            var_dump($_SESSION['username']);
            print_r('level =>');
            var_dump($_SESSION['level']);
            var_dump($query);*/

            if ($query[0] === 'Panel' && isset($_SESSION['username'])) {

                if ($_SESSION['level'] === '1') {
                    require_once(ROOT_FOLDER . '/Views/Templates/AdminPanel.php');
                    View::addErrorLog(ROOT_FOLDER . '/Views/Templates/AdminPanel.php');
                    $this->_view = new AdminPanel();
                }

            } else {
                $form = $query[0];
                var_dump($form);

                $this->_buildForm($form);

                var_dump('submit => ' . $_GET['submit'] . '<br/>');

                print_r('QueryS');
                var_dump($_SERVER['QUERY_STRING']);
                print_r('SCRIPTNAME');
                var_dump($_SERVER['SCRIPT_NAME']);
                print_r('phpself');
                var_dump($_SERVER['PHP_SELF']);
                print_r('HTTP');
                var_dump($_SERVER['HTTP_REFERER']);
                print_r('script');
                var_dump($_SERVER['SCRIPT_FILENAME']);
                var_dump($_GET['login']);

                View::addErrorLog($this->_errorLog);
            }
        }
    }

    //TODO GET SUBMIT = TRUE
    private function _buildForm($form) {
        $this->_usersManager = new UsersManager();

        if (isset($_GET['submit'])) {
            $this->_usersManager->submit();
        }

        $message = $this->_usersManager->getMessageText();

        $this->_view = new ViewUser;
        $this->_view->generate($form, $message);
    }
}