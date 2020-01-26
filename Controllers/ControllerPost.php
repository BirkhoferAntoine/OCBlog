<?php

class ControllerPost
{
    private $_view;
    private $_postsManager;
    private $_commentsManager;
    private $_post;
    private $_safeGet;
    private $_safePost;
    private $_safeUri;

    /**
     * ControllerPost constructor.
     * @param $urlPost
     * @throws Exception
     */
    public function __construct($urlPost)
    {
        if (empty($urlPost)) {
                throw new Exception('404 Page introuvable');
        } else {

            $this->_setSecurity();
                // Recherche les posts
            $this->_selectedPost();
        }
    }

    // Récupère le Post du Postmanager, intègre les éléments du template

    /**
     * @throws Exception
     */
    private function _selectedPost() {
        $this->_postsManager = new PostsManager();
        $this->_commentsManager = new PostCommentsManager();

        isset($this->_safeGet['post']) ?
            $urlPost = $this->_safeGet['post'] : $urlPost = explode('?', $this->_safeUri)[0];
        $this->_post = $this->_postsManager->getPosts(null, '`title` = \'' . $urlPost . '\'');
        $postCheck = $this->_post[0];


        if (!empty($postCheck)) {
            $postId = $postCheck->id();

            if ($this->_safeGet['flag'] === 'submit') {
                $this->_commentsManager->flagComment($this->_safePost['flag']);
                header('Location: '. URL . 'Post/' . $urlPost);
            }

            if ($this->_safeGet['comment'] === 'submit') {
                $this->_commentsManager->addComment($this->_safePost['commentUser'], $this->_safePost['user'], $postId);
                header('Location: '. URL . 'Post/' . $urlPost);
            }


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

    /**
     * @param $idPost
     * @return mixed
     */
    private function _selectedPostComments($idPost) {
        return $this->_commentsManager->getComments('`id`', '`billet_id` = ' . $idPost . ' AND `accepted` >= 1 ');
    }

    /**
     *  Appel de la global $security et récupération des données filtrées
     *  @return void
     */
    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
        $this->_safePost = $security->getFilteredPost();
        $this->_safeUri = $security->getFilteredUri(2);
    }

    /**
     * @return mixed
     */
    public function getPost() {
        return $this->_post;
    }

    /**
     * @return mixed
     */
    public function getView() {
        return $this->_view;
    }
}