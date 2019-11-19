<?php


class ControllerUser extends Controller
{
    private $_usersManager;
    private $_userUrl;
    private $_view;

    public function __construct($url)
    {
        parent::__construct($url);
        if (isset($url) && count($url) > 1) {
            //TODO FILTERVAR?
            throw new Exception('404 Page ' . htmlspecialchars($url) . ' introuvable');
        } else {

            // Decoupe et filtrage de l'url
            $getTest1 = 'login';
            $getTest2 = 'register';
            $getTest3 = 'forgot';
            $getTests = '/(' . $getTest1 . '|' . $getTest2 . '|' . $getTest3 . ')/';

            preg_match($getTests, $_SERVER['QUERY_STRING'], $getMatch);

            print_r('Y');
            var_dump($getMatch);
            print_r('Y');

            $this->_buildForm($getMatch[0]);
        }
    }

    private function _buildForm($form) {
        $this->_usersManager = new UsersManager();

        $this->_view = new ViewUser;
        $this->_view->generate($form);
    }
}