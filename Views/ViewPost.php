<?php


class ViewPost extends View
{
    private $_fileTitle;
    private $_cardTextContent;
    private $_postDate;
    private $_post;

    public function __construct()
    {
        parent::__construct();
    }
    public function generate($injectContent)
    {
        parent::generate($injectContent);
    }
    // TODO CHANGER VIEW
    // Génère les cartes pour les billets si un texte est trouvé dans le fichier
    protected function generateCard() {
        if ($this->_cardTextContent !== null) {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Templates/CardTemplate.php');
            return CardTemplate::_cardBuilder($this->_cardTextContent);
        } else {
            return null;
        }
    }
    protected function generateSelectedPost($injectedPost)
    {
        $this->_post = $injectedPost['Post'][0];
        print_r($this->_post);
        $this->_fileTitle = $this->_post->title();
        $this->_cardTextContent = $this->_post->content();
        $this->_postDate = $this->_post->date_creation();
    }
        protected function generateContent($injectContent) {

        ob_start();

        if ($injectContent['Post']) {
            $this->generateSelectedPost($injectContent);
            echo $this->generateCard();
        }

        return ob_get_clean();
    }

}