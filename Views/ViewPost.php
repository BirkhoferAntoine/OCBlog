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
    protected function generateSelectedPost($injectedPost)
    {
        $this->_post = $injectedPost['Post'];
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