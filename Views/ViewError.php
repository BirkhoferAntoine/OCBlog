<?php

class ViewError extends View {

    private $_fileTitle = 'Erreur';
    public function generate($injectContent)
    {
        parent::generate($injectContent);
    }

    public static function showError($error) {
        return $error['errorMsg'];
        //'<pre>' . print_r($error) . '</pre>';
    }

}
