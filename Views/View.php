<?php


class View
{
    private $_file;
    private $_fileName;
    private $_fileClass;
    private $_fileTitle;
    private $_headerFile;

    // Récupère le nom de la classe View à exécuter et appelle le fichier nécéssaire
    public function __construct($action)
    {
        $this->_fileName = 'View' . $action;

        $this->_file = $_SERVER['DOCUMENT_ROOT'] . '/Views/' . $this->_fileName . '.php';
        require_once($this->_file);

        $this->_fileClass =  new $this->_fileName;
        if ($this->_fileClass::FILE_TITLE !== null) {
            $this->_fileTitle = $this->_fileClass::FILE_TITLE;
        }
        if ($this->_fileClass::HEADER !== null) {
            $this->_headerFile = $this->_fileClass::HEADER;
        }
    }

    // Génère un fichier View et retourne le contenu
    private function generateFile($file, $varInjection) {
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
    private function generateCard() {
        if ($this->_fileClass::CARD_TEXT_CONTENT !== null) {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Templates/CardTemplate.php');
            return CardTemplate::_cardBuilder($this->_fileClass::CARD_TEXT_CONTENT);
        }
    }

    private function generatePosts($injectContent) {
        require_once('Templates/ListedPostTemplate.php');
            new ListedPostTemplate($injectContent);

    }

    // Génère le contenu à injecter
    private function generateContent($injectContent) {

        ob_start();

            if ($this->_headerFile !== null) {
                echo $this->generateFile($_SERVER['DOCUMENT_ROOT'] . $this->_headerFile, null);
            }
            echo $this->generateCard();
            echo $this->generatePosts($injectContent);

        return ob_get_clean();
    }

    // Génère la view à partir du template et récupère puis injecte tout le contenu dans celui-çi
    public function generate($injectContent) {
        // Récupère le contenu
        if ($injectContent{0} === 'true') {
            var_dump($injectContent);
            $viewContent = $this->generateFile($this->_fileName, $injectContent);
        } else {
            $viewContent = $this->generateContent($injectContent);
        }

        // Incrémentation du template
        $view = $this->generateFile($_SERVER['DOCUMENT_ROOT'] . '/Views/template.php', array('fileTitle' => $this->_fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }
}