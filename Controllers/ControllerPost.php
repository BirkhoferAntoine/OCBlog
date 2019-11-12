<?php

// TODO Controller with $_GET['posts'] = new Post, etc...
class ControllerPost extends Controller
{
    private $_view;
    private $_post;
    private $_postsManager;
    private $_commentsManager;

    public function __construct($url)
    {
        parent::__construct($url);
        if (isset($url) && count($url) > 1) {
                throw new Exception('404 Page introuvable');
        } else {
            // Decoupe et filtrage de l'url
            var_dump($_GET["name"] . 'tada');
            $urlPost = $_GET['name'];
            if ($urlPost !== null) {
                $this->_post = $urlPost;
                // Recherche les posts
                $this->_selectedPost($urlPost);
            } else {
                throw new Exception('404 Billet ' . $urlPost . ' introuvable');
            }
        }
    }

    // Récupère le Post du Postmanager, intègre les éléments du template
    private function _selectedPost($urlPost) {
        $this->_postsManager = new PostsManager();
        $post = $this->_postsManager->getPosts(null, '`title` = \'' . $urlPost . '\'');
        print_r($post);

        $this->_view = new ViewPost;
        $this->_view->generate(array('Post' => $post));
    }
}