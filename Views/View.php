<?php


class View
{

    private $_fileTitle;
    private $_cardTextContent;
    private static $_errorLog = [];


    // Récupère le nom de la classe View à exécuter et appelle le fichier nécéssaire
    public function __construct()
    {
        define(TEMPLATE_PATH, ROOT_FOLDER . '/Views/template.php');

    }
    use CardTemplate {
        cardBuilder as protected;
    }

    public static function addErrorLog($add) {
        $addToLog = $add; // html spec char
        if ($add !== $addToLog) {
            $addToLog .= 'NOT SAME';
        }
        static::$_errorLog .= $addToLog;
    }

    public static function showErrorLog() {
        var_dump(static::$_errorLog);
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
            return $this->cardBuilder($this->_cardTextContent, null);
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
            $errorMessage = $injectContent . self::$_errorLog;
            $viewContent = ViewError::showError($errorMessage);
        } else {
            $viewContent = $this->generateContent($injectContent);
        }
        if ($this->_fileTitle !== null) {
            $fileTitle = $this->_fileTitle;
        }

        // Incrémentation du template
        $view = $this->generateFile(TEMPLATE_PATH, array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }
}