<?php

class ControllerHome
{
    private $_postsManager;
    private $_view;


    public function __construct($url)
    {
        if (!empty($url)) {
            throw new Exception('404 Page introuvable');
        }
        else {
            $this->_posts();
        }
    }

    // Récupère les Posts du Postmanager, intègre les éléments de la page d'accueil
    private function _posts() {
        $this->_postsManager = new PostsManager();
        $postsRange = $this->_postsRange();
        $posts = $this->_postsManager->getPosts('`id` DESC LIMIT ' . $postsRange , null);
        View::addErrorLog($posts);

        if ((isset($_GET['editor']) || isset($_GET['comments'])) && $_GET['post'] === 'list') {
            $this->_view = new ListedPostTemplate(array('posts' => $posts));
        } else {
            $this->_view = new ViewHome;
            $this->_view->generate(array('posts' => $posts));
        }
    }

    private function _postsRange()
    {
        if (isset($_GET['listrange'])) {

            $maxRange = $_GET['listrange'] * 10;
            $minRange = $maxRange - 10;
            return $minRange . ', ' . $maxRange;
        } else {
            return '0, 10';
        }
    }
    // TODO GET POSTS AFTER 10 FROM DATABASE
}


