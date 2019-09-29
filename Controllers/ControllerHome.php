<?php

class ControllerHome
{
    private $_postsManager;
    private $_view;

    public function __construct($url)
    {
        $this->posts();
        if (isset($url) && count($url) > 1) {
            throw new Exception('404 Page introuvable');
        }


    }

    private function posts() {
        require_once($_SERVER['DOCUMENT_ROOT'].'/Models/Post.php');
        $this->_postsManager = new PostsManager();
        $posts = $this->_postsManager->getPosts();
        echo 'check';
        echo $posts;

        require_once($_SERVER['DOCUMENT_ROOT'].'/Models/MainModel.php');


        require_once($_SERVER['DOCUMENT_ROOT'].'/View/template.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/View/homeView.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/View/listPostsView.php');
        echo 'tada';
    }

    public function printer() {
        //impression de la page
        echo 'ahah';
        print_r($headerTemplate);
        print_r($navbarTemplate);
        print_r($homeHeroContent);
        print_r($cardTemplate);
        print_r($listPostsContent);
        print_r($footerTemplate);

        echo 'f2';
    }

    public function hBuild() {

        $this->posts();
        $this->printer();
        echo 'f3';

    }

}


