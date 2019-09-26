<?php

class ControllerHome
{
    private $_postsManager;
    private $_view;

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new InvalidArgumentException('404 Page introuvable');
        }
        else {
            $this->_posts();
        }
    }

    private function _posts() {
        $this->_postsManager = new PostsManager();
        $posts = $this->_postsManager->getPosts();

        require_once('../Models/MainModel.php');

        require_once('../View/template.php');
        require_once('../View/homeView.php');
        require_once('../View/listPostsView.php');
    }

    public static function _printer() {
        //impression de la page
        print_r($headerTemplate);
        print_r($navbarTemplate);
        print_r($homeHeroContent);
        print_r($cardTemplate);
        print_r($listPostsContent);
        print_r($footerTemplate);

        echo 'f2';
    }

    public static function hBuild() {

        self::_printer();
        echo 'f3';

    }

}

ControllerHome::hBuild();


