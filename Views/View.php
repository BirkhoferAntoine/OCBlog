<?php


class View
{
    private $_fileTitle;
    private $_cardTextContent;

    // Récupère le nom de la classe View à exécuter et appelle le fichier nécéssaire
    public function __construct()
    {

    }

    // Génère un fichier View et retourne le contenu
    protected function generateFile($file, $varInjection) {
        if (file_exists($file)) {
            // Extrait les variables à injecter et leurs donne un préfixe
            extract($varInjection, EXTR_PREFIX_ALL, 'preViews');

            ob_start();

            // Inclut le fichier View
            require $file;

            return ob_get_clean();
        } else {
            throw new Exception('Fichier ' . $file . ' introuvable');
        }
    }

    // Génère les cartes pour les billets si un texte est trouvé dans le fichier
    protected function generateCard() {
        if ($this->_cardTextContent !== null) {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Templates/CardTemplate.php');
            return CardTemplate::_cardBuilder($this->_cardTextContent);
        } else {
            return null;
        }
    }

    protected function generateSelectedPost($injectContent) {
    }

    // Génère le contenu à injecter
    protected function generateContent($injectContent) {
    }

    // Génère la view à partir du template et récupère puis injecte tout le contenu dans celui-çi
    protected function generate($injectContent) {
        // Récupère le contenu
        if ($injectContent['errorMsg']) {
            $viewContent = ViewError::showError($injectContent);
        } else {
            $viewContent = $this->generateContent($injectContent);
        }
        if ($this->_fileTitle !== null) {
            $fileTitle = $this->_fileTitle;
        }


        // Incrémentation du template
        $view = $this->generateFile($_SERVER['DOCUMENT_ROOT'] . '/Views/template.php', array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }
}