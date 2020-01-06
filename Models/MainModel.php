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

    use PasswordManager;

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

    protected function deleteTableContent($text, $table) {
        $this->getDbConnection();
        $tableQuery = self::$_dbConnection->prepare('
            DELETE FROM ' .
             $table .
             ' WHERE ' .
             $text
             )
        or die(print_r(self::$_dbConnection->errorInfo()));
        $tableQuery->execute();
    }

    protected function newPost($content) {

        $this->getDbConnection();
        $query = self::$_dbConnection->prepare('
        INSERT INTO 
        `Posts`
        VALUES 
        ( :
        
        )
        ');

    }

    protected function updatePost() {

    }

    protected function checkUserExists($userName, $userEmail) {
        $this->getDbConnection();

        $userCheck = self::$_dbConnection->prepare('
			SELECT
				`user_name`, 
				`user_email`
			FROM
				`Users`
			WHERE
				(`user_name` = :user_name 
				OR 
				`user_email` = :user_email)
				');

        // execute sql with actual values
        $userCheck->bindParam(':user_name', $userName);
        $userCheck->bindParam(':user_email', $userEmail);

        // get and return user
        $userCheck->execute();

        $userFetch = $userCheck->fetch();

        if (!empty($userFetch['user_name'])) {
            $message = 'Pseudo déjà utilisé';
        }
        elseif (!empty($userFetch['user_email'])) {
            $message = 'Email déjà utilisé';
        }

        $userCheck->closeCursor();
        return $message;
    }

    protected function checkUserLogin($username, $password) {
        $this->getDbConnection();
        $userCheck = self::$_dbConnection->prepare('
            SELECT 
                `user_name` ,
                `salt` ,
                `iteration`
             FROM 
                `Users` 
             WHERE 
                (`user_name` = :username 
             OR 
                `user_email` = :username)
                ');
        $userCheck->bindParam(':username', $username);

        $userCheck->execute();
        $userCheckFetch = $userCheck->fetch();
        $userCheck->closeCursor();

        if (isset($userCheckFetch)) {
            $passwordToVerify = $this->passwordBuilder($password, $userCheckFetch['salt'], $userCheckFetch['iteration']);
            return $this->_passwordCheck($userCheckFetch['user_name'], $passwordToVerify['password']);
        }
    }

    protected function newUser($username, $email, $password) {
        $this->getDbConnection();

        $insertUser = self::$_dbConnection->prepare('
            INSERT INTO 
                `Users` 
                (`id`, `user_name`, `user_email`, `iteration`, `salt`, `password`, `creation_date`, `user_level`) 
            VALUES 
                (NULL, :user_name, :user_email, :iteration, :salt, :password, UTC_TIMESTAMP(), 0)
        ');

        $cryptedPassword = $this->passwordBuilder($password, null, null);

        $insertUser->bindParam(':user_name', $username);
        $insertUser->bindParam(':user_email', $email);
        $insertUser->bindParam(':iteration', $cryptedPassword['iteration']);
        $insertUser->bindParam(':salt', $cryptedPassword['salt']);
        $insertUser->bindParam(':password', $cryptedPassword['password']);

        $insertUser->execute();
        $insertUser->closeCursor();
    }

    private function _passwordCheck($username, $password) {

        $passCheck = self::$_dbConnection->prepare('
            SELECT 
               `user_name` ,
               `user_email` ,
               `user_level` ,
               `creation_date`
             FROM 
                `Users` 
             WHERE 
                (`user_name` = :user_name
                AND
                `password` = :password)
                ');
        $passCheck->bindParam(':user_name', $username);
        $passCheck->bindParam(':password', $password);
        $passCheck->execute();

        $passCheckFetch = $passCheck->fetch();
        $passCheck->closeCursor();

        return $passCheckFetch;
    }
};