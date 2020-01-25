<?php

    // Classe mère des Views avec fonctions d'intégration

class View
{

    private $_fileTitle;
    private $_cardTextContent;


    // Récupère le nom de la classe View à exécuter et appelle le fichier nécéssaire

    /**
     * View constructor.
     */
    public function __construct()
    {
        define(TEMPLATE_PATH, ROOT_FOLDER . '/Views/template.php');

    }

    // Utilisation du template des cartes de de présentation des billets
    use CardTemplate {
        cardBuilder as protected;
    }


    // Génère un fichier View et retourne le contenu

    /**
     * @param $file
     * @param $varInjection
     * @return false|string
     * @throws Exception
     */
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

    // Génère la view à partir du template et récupère puis injecte tout le contenu dans celui-çi

    /**
     * @param $injectContent
     * @throws Exception
     * @return void
     */
    protected function generate($injectContent) {
        // Récupère le contenu
        if ($injectContent['errorMsg']) {
            $errorMessage = $injectContent;
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