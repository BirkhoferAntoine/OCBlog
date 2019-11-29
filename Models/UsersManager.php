<?php


class UsersManager extends MainModel
{
    // Lien entre la BDD (MainModel) et le controller pour vérifier les données
    private $_status = null;
    private $_message = '';


    public function getMessageText() {
        return $this->_message;
    }

    public function submit() {
        if (isset($_POST['nickname'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
            $this->_userDataCheck();
            print_r($_POST);
        } elseif (isset($_POST['user_identifier'], $_POST['user_password'])) {
            $this->login();
        }
    }

    protected function userExists($userName, $userEmail) {
        return $this->checkUserExists($userName, $userEmail);
    }

    private function _testInput($input)
    {
        $inputFilter1 = trim($input);
        $inputFilter2 = stripslashes($inputFilter1);
        $inputFilterEnd = htmlspecialchars($inputFilter2);
        if ($input !== $inputFilterEnd) {
            return null;
        } elseif ($input === $inputFilterEnd) {
            return $inputFilterEnd;
        }
    }

    private function login() {
        $userData = $_POST;
        $userIdentifier = $this->_testInput($userData['user_identifier']);
        $userPassword = $this->_testInput($userData['user_password']);
        $dbUser = $this->checkUserInfo($userIdentifier);
        $dbPassword = $dbUser['password'];
        var_dump($dbUser);
        if (password_verify($userPassword, $dbPassword)) {
            print_r('LOGGED IN');
            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['nickname'] = $dbUser['user_name'];
            $_SESSION['level'] = $dbUser['user_level'];
            var_dump($_SESSION);
        }
    }

    private function _userDataCheck (){
        $userData = $_POST;
        $userName = $this->_testInput($userData['nickname']);
        $userEmail = $this->_testInput($userData['email']);
        $userPassword = $this->_testInput($userData['password']);
        $userConfPassword = $this->_testInput($userData['confirm_password']);

        if ($userEmail === null || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) { // check email address
            $this->_status = "fail";
            $this->_message = "Email invalide";
        } elseif ($userName === null) {
            $this->_status = "fail";
            $this->_message = "Pseudo invalide";
        } elseif (!empty($this->checkUserExists($userName, $userEmail))) {
            $this->_status = "fail";
            print_r($this->checkUserExists($userName, $userEmail));
            $this->_message = print_r($this->checkUserExists($userName, $userEmail));
        } elseif ($userPassword === null || $userPassword !== $userConfPassword || strlen($userPassword) < 8) { // check password/confirm password
            $this->_status = "fail";
            $this->_message = "Mot de passe invalide ou contenant moins de 8 caractères";
        } else { // all passes so we are all good!
            $this->_status = "ok";
            $this->_message = 'valide';
            // sign the user up to our site!
            print_r($this->_message);
            $this->registerUser($userName, $userEmail, $userPassword);
        }
    }

    private function registerUser($userName, $userEmail, $userPassword) {
        $this->newUser($userName, $userEmail, $userPassword);
    }

}
/*
<pre>
     <?php
     print_r($_SESSION);
     ?>
 </pre>

 <?php
        if (isset($_POST['passInput']))
        {
            $infoTxt = htmlspecialchars($_POST['passInput']);
            if ($infoTxt === "kangourou")
            {
                echo 'Patatate!';
            } else {
                echo 'Ehbahnon!';
            }

        }
     ?>*/