<?php

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
        $postCheck = $post[0];
        $postId = $postCheck->id();

        $postComments = $this->_selectedPostComments($postId);

        $this->_view = new ViewPost;
        $this->_view->setComments($postComments);
        $this->_view->generate(array('Post' => $post));
    }

    private function _selectedPostComments($idPost) {
        $this->_commentsManager = new PostCommentsManager();
        $comments = $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $idPost);
        return $comments;
    }
}