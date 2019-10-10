<?php


class Controller
{
    public function __construct($action) {
        $this->_fileName = 'View' . $action;

        $this->_file = $_SERVER['DOCUMENT_ROOT'] . '/Views/' . $this->_fileName . '.php';
        if (file_exists($this->_file)) {
            require_once($this->_file);
        } else {
            throw new Exception('404 Fichier ' . $this->_file . ' introuvable');
        }
    }
}