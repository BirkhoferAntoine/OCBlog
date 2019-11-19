<?php

class ControllerHome extends Controller
{
    private $_postsManager;
    private $_view;


    public function __construct($url)
    {
        parent::__construct($url);
        if (isset($url) && count($url) > 1) {
            throw new Exception('404 Page Home introuvable');
        }
        else {
            $this->_posts();
        }
    }

    // Récupère les Posts du Postmanager, intègre les éléments de la page d'accueil
    private function _posts() {
        $this->_postsManager = new PostsManager();
        $posts = $this->_postsManager->getPosts('`id` DESC LIMIT 0, 10', null);
        print_r($posts);

        $this->_view = new ViewHome;
        $this->_view->generate(array('posts' => $posts));
    }
    // TODO GET POSTS AFTER 10 FROM DATABASE
}


