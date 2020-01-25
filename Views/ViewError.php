<?php

    // Classe d'affichage des erreurs

class ViewError extends View {

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
     * @param $error
     * @return mixed
     */
    public static function showError($error) {
        return $error['errorMsg'];
    }

}
