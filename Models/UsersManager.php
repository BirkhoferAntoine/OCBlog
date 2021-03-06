<?php

    // Classe de gestion des utilisateurs

class UsersManager extends MainModel
{
    // Lien entre la BDD (MainModel) et le controller pour vérifier les données
    private $_message = '';
    private $_userData;

    /**
     * UsersManager constructor.
     */
    public function __construct()
    {
        $this->_setUserData();
    }

    /**
     * @return string
     */
    public function getMessageText() {
        return $this->_message;
    }

    /**
     * @return void
     */
    public function submit() {
        return $this->_submitUserData();
    }

    /**
     * @return void
     */
    private function _submitUserData() {
        if (isset(
            $this->_userData['login_identifier'],
            $this->_userData['login_password'])) {
                return $this->_login();
            } elseif (isset(
            $this->_userData['register_user_name'],
            $this->_userData['register_user_email'],
            $this->_userData['register_password'],
            $this->_userData['register_confirm_password'])) {
                $this->_checkUserRegister();
        }
    }

    // Set données $_POST filtrées

    /**
     * @return void
     */
    private function _setUserData() {
        global $security;
        $this->_userData = $security->getFilteredPost();
    }

    // Filtre et vérifie les données envoyées par l'utilisateur

    /**
     * @param $input
     * @return string|null
     */
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

    // Vérifie les données envoyées lors du formulaire de connexion et effectue une connexion et redirection si elles sont justes
    /**
     * @return void
     */
    private function _login() {

        $userIdentifier = $this->_testInput($this->_userData['login_identifier']);
        $userPassword = $this->_testInput($this->_userData['login_password']);
        $dbUser = $this->checkUserLogin($userIdentifier, $userPassword);

        if (!empty($dbUser)) {

            $_SESSION['logedin'] = true;
            $_SESSION['username'] = $dbUser['user_name'];
            $_SESSION['level'] = $dbUser['user_level'];

            header('Location: ' . URL);
        }
    }

    // Vérifie les données envoyées lors du formulaire inscription
    /**
     * @return string
     */
    private function _checkUserRegister (){

        $userName = $this->_testInput($this->_userData['register_user_name']);
        $userEmail = $this->_testInput($this->_userData['register_user_email']);
        $userPassword = $this->_testInput($this->_userData['register_password']);
        $userConfPassword = $this->_testInput($this->_userData['register_confirm_password']);
        $userExists = $this->checkUserExists($userName, $userEmail);

        if ($userEmail === null || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) { // check email address
            return $this->_message = "Email invalide";
        } elseif ($userName === null) {
            return $this->_message = "Pseudo invalide";
        } elseif (!empty($userExists)) {
            return $this->_message = $userExists;
        } elseif ($userPassword === null || $userPassword !== $userConfPassword || (strlen($userPassword) < 8) || (strlen($userPassword)) > 128) { // check password/confirm password
            return $this->_message = "Mot de passe invalide ou contenant moins de 8 caractères";
        } else {
            // Si toutes les conditions sont validées nous pouvons enregistrer le nouvel utilisateur
            $this->_message = 'Bienvenue';
            $this->registerUser($userName, $userEmail, $userPassword);
            // Puis le connecter
            $this->_userData['login_identifier'] = $userName;
            $this->_userData['login_password'] = $userPassword;
            $this->_login();
        }
    }

    // Set nouvel utilisateur
    /**
     * @param $userName
     * @param $userEmail
     * @param $userPassword
     * @return void
     */
    private function registerUser($userName, $userEmail, $userPassword) {
        return $this->newUser($userName, $userEmail, $userPassword);
    }

}