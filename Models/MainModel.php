<?php
    //Classe abstraite car sert uniquement à accèder a la BDD
abstract class MainModel {

    private static $_dbConnection;
    private const HOST_NAME = 'db5000177647.hosting-data.io';
    private const DATABASE = 'dbs172441';
    private const USER_NAME = 'dbu35984';
    private const PASSWORD = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';
    private const CHARSET = 'utf8mb4';
    private const DSN = "mysql:host=" . self::HOST_NAME . "; dbname=" . self::DATABASE . "; charset=" . self::CHARSET . ";";
    private const DBOPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    private $_errorLog = [];

    // Connection à la BDD suivant les directives du server
    private static function setDbConnection() {
        try {
            self::$_dbConnection = new PDO(self::DSN, self::USER_NAME, self::PASSWORD, self::DBOPTIONS);
        }
        catch (PDOException $e) {
            echo "Erreur!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Vérifie si la connection est établie, se connecte si null et renvoie le resultat
    protected function getDbConnection() {
        if (self::$_dbConnection === null) {
            self::setDbConnection();
        }
        return self::$_dbConnection;
    }

    // Vérifie et effectue connection à la BDD, récupère les données de la table et les intègre dans de nouveaux objets
    protected function getTableContent($table, $object, $order, $where) {

        $this->getDbConnection();
        $tableContent = [];

        if ($order !== null){
            $orderSelect = ' ORDER BY ' . $order;
        } else {
            $orderSelect = '';
        }
        if ($where !== null ) {
            $whereSelect = ' WHERE ' . $where;
        } else {
            $whereSelect = '';
        }

        $tableQuery = self::$_dbConnection->prepare('
            SELECT 
                * 
            FROM 
                ' . $table . $whereSelect . $orderSelect
        )
        or die(print_r(self::$_dbConnection->errorInfo()));

        $tableQuery->execute();
        if (isset($tableQuery)) {
            while ($tableQueryData = $tableQuery->fetch()){
                $tableContent[] = new $object($tableQueryData);
            }
        }
        $tableQuery->closeCursor();
        return $tableContent;
    }

    protected function checkUserExists($userName, $userEmail) {
        $this->getDbConnection();

        $this->_errorLog .= 'CHECK USER EXISTS => ' . $userName . $userEmail . '<br/>';

        $userNameCheck = self::$_dbConnection->prepare('
			SELECT
				`user_name`
			FROM
				`Users`
			WHERE
				`user_name` = :user_name');

        $userEmailCheck = self::$_dbConnection->prepare('
			SELECT
				`user_email`
			FROM
				`Users`
			WHERE
				`user_email` = :user_email');
        // execute sql with actual values
        $userNameCheck->bindParam(':user_name', $userName);
        $userEmailCheck->bindParam(':user_email', $userEmail);

        $userNameCheck->execute();
        $userEmailCheck->execute();
        // get and return user
        $userNameFetch = $userNameCheck->fetch();
        $userEmailFetch = $userEmailCheck->fetch();

        $message = [];
        if (!empty($userNameFetch)) {
            $message[1] = 'Nickname already exists';
        }
        if (!empty($userEmailFetch)) {
            $message[2] = 'Email already exists';
        }

        print_r('USERCHECK');
        var_dump($userNameFetch);
        var_dump($userEmailFetch);
        var_dump($message);
        print_r('USERCHECK');

        $userNameCheck->closeCursor();
        $userEmailCheck->closeCursor();

        View::addErrorLog($this->_errorLog);
        return $message;
    }

    protected function checkUserInfo($username) {
        $this->getDbConnection();
        $userCheck = self::$_dbConnection->prepare('
            SELECT 
                `user_name` ,
                `password` ,
                `user_level`
             FROM 
                `Users` 
             WHERE 
                (`user_name` = :username 
             OR 
                `user_email` = :username)
                ');
        $userCheck->bindParam(':username', $username);

        print_r($userCheck);

        $userCheck->execute();
        $userCheckFetch = $userCheck->fetch();

        if (isset($userCheckFetch)) {
            print_r('SuccessUser!');
            var_dump($userCheckFetch);
            return $userCheckFetch;
        }
        $userCheck->closeCursor();
    }

    protected function newUser($username, $email, $password) {
        $this->getDbConnection();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertUser = self::$_dbConnection->prepare('
            INSERT INTO 
                `Users` 
                (`id`, `user_name`, `user_email`, `password`, `creation_date`, `user_level`) 
            VALUES 
                (NULL, :user_name, :user_email, :password, UTC_TIMESTAMP(), 0)
        ');
        $insertUser->bindParam(':user_name', $username);
        $insertUser->bindParam(':user_email', $email);
        $insertUser->bindParam(':password', $hashedPassword);

        $insertUser->execute();

        print_r('TODATA');
        var_dump($insertUser);
        $insertUser->closeCursor();
    }
};