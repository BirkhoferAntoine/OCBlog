<?php


class PostComments
{   private $_id;
    private $_user;
    private $_comment;
    private $_comment_date;

    public function __construct(array $tableQueryData)
    {
        $this->hydrate($tableQueryData);
    }

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
    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        };
    }

    public function setUser($user) {
        if (is_string($user)) {
            $this->_user = htmlspecialchars($user);
        }
    }

    public function setComment($comment) {
        if (is_string($comment)) {
            $this->_comment = htmlspecialchars($comment);
        }
    }

    public function setComment_date($comment_date) {
        $this->_comment_date = $comment_date;
    }

    // GETTERS
    public function id() {
        return $this->_id;
    }

    public function user() {
        return $this->_user;
    }

    public function comment() {
        return $this->_comment;
    }

    public function comment_date() {
        return $this->_comment_date;
    }

}