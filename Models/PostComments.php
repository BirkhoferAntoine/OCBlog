<?php

    // Classe d'hydratation des commentaires de billets

class PostComments {
    private $_id;
    private $_billet_id;
    private $_user;
    private $_comment;
    private $_comment_date;

    /**
     * PostComments constructor.
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
        if ($id >= 0) {
            $this->_id = $id;
        }
    }

    /**
     * @param $billet_id
     */
    public function setBillet_id($billet_id) {
        $billet_id = (int) $billet_id;
        if ($billet_id >= 0) {
            $this->_billet_id = $billet_id;
        }
    }

    /**
     * @param $user
     */
    public function setUser($user) {
        if (is_string($user)) {
            $this->_user = htmlspecialchars($user);
        }
    }

    /**
     * @param $comment
     */
    public function setComment($comment) {
        if (is_string($comment)) {
            $this->_comment = htmlspecialchars($comment);
        }
    }

    /**
     * @param $comment_date
     */
    public function setComment_date($comment_date) {
        $this->_comment_date = $comment_date;
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
    public function billet_id() {
        return $this->_billet_id;
    }

    /**
     * @return mixed
     */
    public function user() {
        return $this->_user;
    }

    /**
     * @return mixed
     */
    public function comment() {
        return $this->_comment;
    }

    /**
     * @return mixed
     */
    public function comment_date() {
        return $this->_comment_date;
    }

}