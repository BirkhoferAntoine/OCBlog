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
            $form = $query[0];
            var_dump($form);

            $this->_buildForm($form);

            var_dump('submit => ' . $_GET['submit'] . '<br/>');


            var_dump(isset($_GET['Login']));
            var_dump(isset($_GET['register']));
            print_r('parseURL');
            $parseURL = parse_url($_SERVER['QUERY_STRING'], PHP_URL_QUERY);
            var_dump($parseURL);
            print_r('parseSTR');
            $queries = [];
            var_dump(parse_str($_SERVER['QUERY_STRING'], $queries));

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