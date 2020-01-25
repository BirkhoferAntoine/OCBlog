<?php

class ViewHome extends View {

    private $_title = "Accueil";
    private $_cardTextContent = "A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.";
    private $_header = '/Views/Templates/headerTemplate.php';

    /**
     * ViewHome constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     * @return void
     */
    protected function generateHeader() {
        if ($this->_header !== null) {
            echo $this->generateFile(ROOT_FOLDER . $this->_header, null);
        }
    }

    /**
     * @param $injectContent
     * @return ListedPostTemplate
     */
    protected function generatePostsList($injectContent) {
        return new ListedPostTemplate($injectContent);
    }

    // Génère les cartes pour les billets si un texte est trouvé dans le fichier

    /**
     * @return false|string|null
     */
    protected function generateCard() {
        if ($this->_cardTextContent !== null) {
            return $this->cardBuilder($this->_cardTextContent, null, null);
        } else {
            return null;
        }
    }

    /**
     * @param $injectContent
     * @return false|string
     * @throws Exception
     */
    protected function generateContent($injectContent) {

        ob_start();

        $this->generateHeader();
        echo $this->generateCard();
        $this->generatePostsList($injectContent);

        return ob_get_clean();
    }


    /**
     * @param $injectContent
     * @throws Exception
     */
    public function generate($injectContent) {
        // Récupère le contenu

            $viewContent = $this->generateContent($injectContent);

        if ($this->_title !== null) {
            $fileTitle = $this->_title;
        }

        // Incrémentation du template
        $view = $this->generateFile(TEMPLATE_PATH, array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }
}
