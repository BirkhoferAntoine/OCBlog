<?php

class ControllerHome
{
    private $_postsManager;
    private $_view;
    private $_safeGet;


    /**
     * ControllerHome constructor.
     * @param null $url
     * @throws Exception
     * @return void
     */
    public function __construct($url=null)
    {
        if (!empty($url)) {
            throw new Exception('404 Page introuvable');
        }
        else {
            $this->_setSecurity();
            if ($this->_safeGet['logout'] === 'true') {
                session_destroy();
            }
            $this->_posts();
        }
    }

    // Récupère les Posts du Postmanager, intègre les éléments de la page d'accueil

    /**
     * @return void
     */
    private function _posts() {
        $this->_postsManager = new PostsManager();
        $postsRange = $this->_postsRange();
        $posts = $this->_postsManager->getPosts('`id` DESC LIMIT ' . $postsRange , null);

        if ((isset($this->_safeGet['editor']) || isset($this->_safeGet['comments'])) && $this->_safeGet['post'] === 'list') {
            $this->_view = new ListedPostTemplate(array('posts' => $posts));
        } else {
            $this->_view = new ViewHome;
            $this->_view->generate(array('posts' => $posts));
        }
    }

    /**
     * @return string
     */
    private function _postsRange()
    {
        if (isset($this->_safeGet['listrange'])) {

            $maxRange = $this->_safeGet['listrange'] * 10;
            $minRange = $maxRange - 10;
            return $minRange . ', ' . $maxRange;
        } else {
            return '0, 10';
        }
    }

    /**
     * @return void
     */
    private function _setSecurity() {
        global $security;
        $this->_safeGet = $security->getFilteredGet();
    }
}


