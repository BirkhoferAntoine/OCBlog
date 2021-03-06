<?php


class ViewPost extends View
{
    private $_fileTitle;
    private $_cardTextContent;
    private $_postDate;
    private $_post;
    private $_postComments;
    private $_postImage;


    /**
     * @param $injectContent
     * @throws Exception
     * @return void
     */
    public function generate($injectContent)
    {
        parent::generate($injectContent);
    }

    /**
     * @param $comments
     */
    public function setComments($comments) {
        return $this->_postComments = $comments;
    }

    // Génère les cartes pour les billets si un texte est trouvé dans le fichier

    /**
     * @return false|string|null
     */
    protected function generateCard() {
        if ($this->_cardTextContent !== null) {
            return $this->cardBuilder($this->_cardTextContent,
                $this->_postDate,
                $this->_postImage);
        } else {
            return null;
        }
    }

    /**
     * @param $injectedPost
     */
    protected function generateSelectedPost($injectedPost)
    {
        if (empty($injectedPost['preview'])) {

            $this->_post = $injectedPost['Post'][0];
            $this->_fileTitle = $this->_post->title();
            $this->_cardTextContent = $this->_post->content();
            $this->_postDate = $this->_post->date_creation();
            $this->_postImage = $this->_post->image();
        } else {

            $this->_post = $injectedPost['preview'];
            $this->_fileTitle = $this->_post['postTitle'];
            $this->_cardTextContent = $this->_post['postContent'];
            $this->_postImage = $this->_post['postUrlImage'];
            $this->_postDate = $injectedPost['Post'][0]->date_creation();
        }
    }

    /**
     * @return CommentsTemplate
     */
    protected function generatePostComments() {
        return new CommentsTemplate($this->_postComments);
    }

    /**
     * @param $injectContent
     * @return false|string
     */
    protected function generateContent($injectContent) {
        $this->generateSelectedPost($injectContent);

        if ($injectContent['Post']) {

            ob_start();

            echo $this->generateCard();
            $this->generatePostComments();

            return ob_get_clean();
        }
    }

    /**
     * @param $injectContent
     * @return false|string
     */
    public function generatePost($injectContent) {
        return $this->generateContent($injectContent);
    }


}