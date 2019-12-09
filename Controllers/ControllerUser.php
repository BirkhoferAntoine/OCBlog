<?php


class ControllerUser
{
    private $_usersManager;
    private $_view;
    private $_panel;
    private $_errorLog = [];

    public function __construct($url)
    {
        if (empty($url) || count($url) > 1) {
            throw new Exception('404 Page ' . htmlspecialchars($url) . ' introuvable');
        } else {
            // Decoupe et filtrage de l'url

            $this->_errorLog .= 'URL => ' . $url . '<br/>';
            View::addErrorLog($_POST);

            $query = explode('&', $url);

            //TODO COOKIE
            /*var_dump($_COOKIE);
            var_dump($_SESSION['username']);
            print_r('level =>');
            var_dump($_SESSION['level']);
            var_dump($query);*/

            if ($query[0] === 'Panel' && isset($_SESSION['username'])) {

                if ($_SESSION['level'] === '1') {
                    require_once(ROOT_FOLDER . '/Views/Templates/AdminPanel.php');
                    View::addErrorLog(ROOT_FOLDER . '/Views/Templates/AdminPanel.php');
                    $this->_panel = new AdminPanel();
                }

            } else {
                $form = $query[0];

                $this->_buildForm($form);

                View::addErrorLog('submit => ' . $_GET['submit'] . '<br/>');

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