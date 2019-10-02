<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/View.php');

class ControllerHome
{
    private $_postsManager;
    private $_view;
    private $_headerContent;
    private $_card;

    public function __construct($url)
    {
        if (isset($url) && count($url) > 1) {
            throw new Exception('404 Page introuvable');
        }
        else {
            $this->_posts();
            $this->_card();
        }
    }

    // Récupère les Posts du Postmanager, intègre les éléments de la page d'accueil
    private function _posts() {
        $this->_postsManager = new PostsManager();
        $posts = $this->_postsManager->getPosts();

        $this->_view = new View('Home');
        $this->_view->generate(array('posts' => $posts));
    }

    // TODO: Assembler la carte depuis le controleur (viewHome -> controlleur + CardTemplate -> controlleur = HomeCard)
    private function _card() {
        $cardTextContent = getCardTextContent();
        $this->_card = new CardTemplate($cardTextContent);
        $this->_view->generate(array('card' => $this->_card));
    }


}


