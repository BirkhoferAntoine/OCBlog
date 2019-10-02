<?php


class View
{
    private $_file;
    private $_metaTitle;

    public function __construct($action)
    {
        $this->_file = $_SERVER['DOCUMENT_ROOT'] . '/Views/view' . $action . '.php';
    }

    // Génère un fichier Views et retourne le résultat
    private function generateFile($file, $fileContent/*, $fileHeader*/) {
        if (file_exists($file)) {
            extract($fileContent/*, EXTR_PREFIX_ALL, 'preViews'*/);

            ob_start();

            // Inclut le fichier Views
            require $file;

            return ob_get_clean();
        } else {
            throw new Exception('Fichier ' . $file . ' introuvable');
        }
    }

    // Génère et affiche la Views
    public function generate($fileContent) {
        // Contenu spécifique de la Views
        $viewContent = $this->generateFile($this->_file, $fileContent);

        // Incrémentation du template
        $view = $this->generateFile($_SERVER['DOCUMENT_ROOT'] . '/Views/template.php', array('metaTitle' => $this->_metaTitle, 'viewContent' => $viewContent));

        echo $view;
    }

}