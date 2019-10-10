<?php

// TODO Controller with $_GET['posts'] = new PostModel, etc...
class ControllerPosts extends Controller
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
            $urlPost = explode('?', filter_var($url, FILTER_SANITIZE_URL));
            if ($urlPost[0] !== null) {
                $this->_post = $urlPost[0];
                // Recherche les posts
                $this->_selectedPost();
            } else {
                throw new Exception('404 Billet ' . $urlPost[0] . ' introuvable');
            }
        }
    }

    // Récupère le PostModel du Postmanager, intègre les éléments du template
    private function _selectedPost() {
        $this->_postsManager = new PostsManagerModel();
        $post = $this->_postsManager->getPosts('`id` DESC', '`title` = ' . $this->_post);

        $this->_view = new ViewPost;
        $this->_view->generate(array('Post' => $post));
    }
}