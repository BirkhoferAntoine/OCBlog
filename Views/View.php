<?php


class View
{

    private $_fileTitle;
    private $_cardTextContent;


    // Récupère le nom de la classe View à exécuter et appelle le fichier nécéssaire
    public function __construct()
    {
        define(TEMPLATE_PATH, ROOT_FOLDER . '/Views/template.php');

    }
    use CardTemplate {
        cardBuilder as protected;
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

    // Génère la view à partir du template et récupère puis injecte tout le contenu dans celui-çi
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