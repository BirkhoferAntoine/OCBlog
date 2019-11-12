<?php

class ViewHome extends View {

    private $_title = "Accueil";
    private $_cardTextContent = "A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.";
    private $_header = '/Views/Templates/headerTemplate.php';

    public function __construct()
    {
        parent::__construct();
    }

    protected function generateHeader() {
        if ($this->_header !== null) {
            echo $this->generateFile($_SERVER['DOCUMENT_ROOT'] . $this->_header, null);
        }
    }

    protected function generatePostsList($injectContent) {
        require_once('Templates/ListedPostTemplate.php');
        new ListedPostTemplate($injectContent);
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

    protected function generateContent($injectContent) {

        ob_start();

        $this->generateHeader();
        if ($injectContent['posts']) {
            echo $this->generateCard();
            echo $this->generatePostsList($injectContent);
        }
        return ob_get_clean();
    }


    public function generate($injectContent) {
        // Récupère le contenu
        if ($injectContent['errorMsg']) {
            $viewContent = ViewError::showError($injectContent);
        } else {
            $viewContent = $this->generateContent($injectContent);
        }
        if ($this->_title !== null) {
            $fileTitle = $this->_title;
        }


        // Incrémentation du template
        $view = $this->generateFile($_SERVER['DOCUMENT_ROOT'] . '/Views/template.php', array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }


}



/*foreach ($posts as $post) : ?>

<?php endforeach; ?>*/
