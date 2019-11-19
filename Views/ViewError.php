<?php

class ViewError extends View {

    public function generate($injectContent)
    {
        parent::generate($injectContent);
    }

    public static function showError($error) {
        return $error['errorMsg'];
    }

}
