<?php

class ControllerPost
{
    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_post;
    private $_safeGet;
    private $_safePost;

    public function __construct($urlPost)
    {
        if (empty($urlPost)) {
                throw new Exception('404 Page introuvable');
        } else {

            $this->_setSecurity();
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

            $this->_view = new ViewPost();
            $this->_view->setComments($postComments);


            if ($this->_safeGet['editor'] === 'edit' && $this->_safeGet['submit'] === 'preview') {
                $this->_view->generatePost(array(
                        'Post' => $this->_post,
                        'preview' => array(
                            'postTitle' => $this->_safePost['postTitle'],
                            'postContent' => $this->_safePost['postContent'],
                            'postUrlImage' => $this->_safePost['postUrlImage'],
                            'postId' => $this->_safePost['postId']
                        )
                    )
                );
            } elseif (((isset($this->_safeGet['editor']) && $this->_safeGet['submit'] !== 'preview') ||
                    isset($this->_safeGet['comments'])) && $this->_safeGet['post'] !== 'list') {
                $this->_view->generatePost(array('Post' => $this->_post));
            } else {
                $this->_view->generate(array('Post' => $this->_post));
            }
        } else {
            throw new Exception('404 Billet ' . $urlPost . ' introuvable');
        }
    }

    private function _selectedPostComments($idPost) {
        $this->_commentsManager = new PostCommentsManager();
        return $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $idPost . ' AND `accepted` >= 1 ');
    }

    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
        $this->_safePost = $security->getFilteredPost();

    }

    public function getPost() {
        return $this->_post;
    }
    public function getView() {
        return $this->_view;
    }
}