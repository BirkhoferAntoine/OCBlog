<?php


trait PasswordManager
{
    private $_saltBytes = 32;
    private $_algorithm = 'sha3-512';
    private $_iteration = 10000;

    private function _salter() {
        try {
            return bin2hex(random_bytes($this->_saltBytes));
        } catch (PDOException $e) {
            echo 'Erreur!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    protected function passwordBuilder($password, $salt, $iteration) {

        $hashSalt = $salt ?? $this->_salter();
        $hashIteration = $iteration ?? $this->_iteration;
        $hashPassword = hash($this->_algorithm, $password, false);
        $finalPassword = hash_pbkdf2($this->_algorithm, $hashPassword, $hashSalt, $hashIteration);

        $passStorage = array('iteration' => $hashIteration, 'salt' => $hashSalt, 'password' => $finalPassword);

        return $passStorage;
    }
}