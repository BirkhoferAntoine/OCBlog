<?php

class Post {
    private $_id;
    private $_title;
    private $_content;
    private $_date_creation;

    public function __construct(array $tableQueryData)
    {
        $this->hydrate($tableQueryData);
    }

    public function hydrate(array $tableQueryDate) {
        foreach ($tableQueryDate as $key => $value) {
            echo 'hydrate1';
            $method = 'set' . ucfirst($key);
            echo 'hydrate2';

            if (method_exists($this, $method)) {
                $this->$method($value);
                echo 'hydrate3';
            }
        }
    }

    // SETTERS
    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        };
    }

    public function setTitle($title) {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    public function setContent($content) {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setDateCreation($date_creation) {
        $this->_date_creation = $date_creation;
    }

    // GETTERS
    public function id() {
        return $this->_id;
    }

    public function title() {
        return $this->_title;
    }

    public function content() {
        return $this->_content;
    }

    public function date_creation() {
        return $this->_date_creation;
    }
}

