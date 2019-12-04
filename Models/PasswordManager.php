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

        $iteration ?? $this->_iteration;
        $salt ?? $this->_salter();
        print_r($iteration);
        print_r($salt);
        $hash = hash($this->_algorithm, $password, false);
        $finalPassword = hash_pbkdf2($this->_algorithm, $hash, $salt, $iteration);

        $passStorage = array('iteration' => $iteration, 'salt' => $salt, 'password' => $finalPassword);
        var_dump($passStorage);

        return $passStorage;
    }
}