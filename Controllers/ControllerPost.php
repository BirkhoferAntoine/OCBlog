<?php

class ControllerPost
{
    private $_view;
    private $_postsManager;
    private $_commentsManager;

    public function __construct($urlPost)
    {
        if (empty($urlPost)) {
                throw new Exception('404 Page introuvable');
        } else {
            var_dump($urlPost);
                // Recherche les posts
            $this->_selectedPost($urlPost);
        }
    }

    // Récupère le Post du Postmanager, intègre les éléments du template
    private function _selectedPost($urlPost) {
        $this->_postsManager = new PostsManager();
        $post = $this->_postsManager->getPosts(null, '`title` = \'' . $urlPost . '\'');
        $postCheck = $post[0];

        if (!empty($postCheck)) {
            $postId = $postCheck->id();

            $postComments = $this->_selectedPostComments($postId);

            $this->_view = new ViewPost;
            $this->_view->setComments($postComments);
            $this->_view->generate(array('Post' => $post));
        } else {
            throw new Exception('404 Billet ' . $urlPost . ' introuvable');
        }
    }

    private function _selectedPostComments($idPost) {
        $this->_commentsManager = new PostCommentsManager();
        $comments = $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $idPost);
        return $comments;
    }
}