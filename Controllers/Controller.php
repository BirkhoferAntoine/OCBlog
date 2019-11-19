<?php


class Controller
{
    public function __construct($action) {
        $this->_fileName = 'View' . $action[0];
        var_dump($this->_fileName . ' here ');

        $this->_file = ROOT_FOLDER . '/Views/' . $this->_fileName . '.php';
        if (file_exists($this->_file)) {
            require_once($this->_file);
        } else {
            throw new Exception('404 Fichier ' . $this->_file . ' introuvable');
        }
    }
}