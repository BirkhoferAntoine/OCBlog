<?php

    // Classe d'hydratation des billets

class Post {
    private $_id;
    private $_title;
    private $_content;
    private $_date_creation;
    private $_image;

    /**
     * Post constructor.
     * @param array $tableQueryData
     */
    public function __construct(array $tableQueryData)
    {
        $this->hydrate($tableQueryData);
    }

    /**
     * @param array $tableQueryData
     */
    public function hydrate(array $tableQueryData) {

        // Incrémentation automatique des méthodes pour l'hydratation
        foreach ($tableQueryData as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // SETTERS

    /**
     * @param $id
     */
    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    /**
     * @param $title
     */
    public function setTitle($title) {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    /**
     * @param $date_creation
     */
    public function setDate_creation($date_creation) {
        $this->_date_creation = $date_creation;
    }

    /**
     * @param $image
     * @return null
     */
    public function setImage($image) {
        if ($image !== '') {
            $this->_image = $image;
        } else {
            return null;
        }
    }

    // GETTERS

    /**
     * @return mixed
     */
    public function id() {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function title() {
        return $this->_title;
    }

    /**
     * @return mixed
     */
    public function content() {
        return $this->_content;
    }

    /**
     * @return mixed
     */
    public function date_creation() {
        return $this->_date_creation;
    }

    /**
     * @return mixed
     */
    public function image() {
        return $this->_image;
    }
}

