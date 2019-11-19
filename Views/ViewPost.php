<?php


class ViewPost extends View
{
    private $_fileTitle;
    private $_cardTextContent;
    private $_postDate;
    private $_post;
    private $_postComments;
    private $_postImage;

    public function __construct()
    {
        parent::__construct();
    }
    public function generate($injectContent)
    {
        parent::generate($injectContent);
    }

    public function setComments($comments) {
        $this->_postComments = $comments;
    }

    // TODO CHANGER VIEW
    // Génère les cartes pour les billets si un texte est trouvé dans le fichier
    protected function generateCard() {
        if ($this->_cardTextContent !== null) {
            return $this->cardBuilder($this->_cardTextContent, $this->_postDate, $this->_postImage);
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
        $this->_postImage = $this->_post->image();
    }

    protected function generatePostComments() {

        print_r($this->_postComments);
        return new CommentsTemplate($this->_postComments);
    }

    protected function generateContent($injectContent) {

        ob_start();

        if ($injectContent['Post']) {
            $this->generateSelectedPost($injectContent);
            print_r($this->generateCard());
            print_r($this->generatePostComments());
        }

        return ob_get_clean();
    }

}