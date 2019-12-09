<?php


class ViewPost extends View
{
    private $_fileTitle;
    private $_cardTextContent;
    private $_postDate;
    private $_post;
    private $_postComments;
    private $_postImage;

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
        $this->_fileTitle = $this->_post->title();
        $this->_cardTextContent = $this->_post->content();
        $this->_postDate = $this->_post->date_creation();
        $this->_postImage = $this->_post->image();
    }

    // TODO COMMENTS FORM
    protected function generatePostComments() {
        return new CommentsTemplate($this->_postComments);
    }

    protected function generateContent($injectContent) {

        if ($injectContent['Post']) {
            $this->generateSelectedPost($injectContent);

            ob_start();

            print_r($this->generateCard());
            $this->generatePostComments();

            return ob_get_clean();
        }
    }

    public function generatePost($injectContent) {
        return $this->generateContent($injectContent);
    }

}