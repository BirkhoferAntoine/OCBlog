<?php

class ControllerPost
{
    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_post;

    public function __construct($urlPost)
    {
        if (empty($urlPost)) {
                throw new Exception('404 Page introuvable');
        } else {
                // Recherche les posts
            $this->_selectedPost($urlPost);
        }
    }

    // Récupère le Post du Postmanager, intègre les éléments du template
    private function _selectedPost($urlPost) {
        $this->_postsManager = new PostsManager();
        $this->_post = $this->_postsManager->getPosts(null, '`title` = \'' . $urlPost . '\'');
        $postCheck = $this->_post[0];

        if (!empty($postCheck)) {
            $postId = $postCheck->id();

            $postComments = $this->_selectedPostComments($postId);

            if ((isset($_GET['editor']) || isset($_GET['comments'])) && $_GET['post'] !== 'list') {
                $this->_view = new ViewPost;
                $this->_view->setComments($postComments);
                $this->_view->generatePost(array('Post' => $this->_post));
            } else {
                $this->_view = new ViewPost;
                $this->_view->setComments($postComments);
                $this->_view->generate(array('Post' => $this->_post));
            }
        } else {
            throw new Exception('404 Billet ' . $urlPost . ' introuvable');
        }
    }

    private function _selectedPostComments($idPost) {
        $this->_commentsManager = new PostCommentsManager();
        $comments = $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $idPost);
        return $comments;
    }

    public function getPost() {
        return $this->_post;
    }
    public function getView() {
        return $this->_view;
    }
}