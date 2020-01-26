<?php

    // Trait de gestion des mots de passe

trait PasswordManager
{
    private $_saltBytes = 32;
    private $_algorithm = 'sha3-512';
    private $_iteration = 10000;

    /**
     * Génère un salt "aléatoire"
     *
     * @return string
     * @throws Exception
     */
    private function _salter() {
        try {
            return bin2hex(random_bytes($this->_saltBytes));
        } catch (PDOException $e) {
            echo 'Erreur!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    /**
     * Construit le mot de passe et utilise les arguments de l'utilisateur et de la BDD si c'est une connexion
     *
     * @param $password
     * @param $salt
     * @param $iteration
     * @return array
     * @throws Exception
     */
    protected function passwordBuilder($password, $salt, $iteration) {

        $hashSalt = $salt ?? $this->_salter();
        $hashIteration = $iteration ?? $this->_iteration;
        $hashPassword = hash($this->_algorithm, $password, false);
        $finalPassword = hash_pbkdf2($this->_algorithm, $hashPassword, $hashSalt, $hashIteration);

        $passStorage = array('iteration' => $hashIteration, 'salt' => $hashSalt, 'password' => $finalPassword);

        return $passStorage;
    }
}