<?php
    //Classe abstraite car sert uniquement à accèder a la BDD
abstract class MainModel {

    // Variable contenant la base de données
    private static $_dbConnection;
    // Constantes pour construire la requête pour accèder à la base de données
    private const HOST_NAME = 'localhost';
    private const DATABASE = 'dbs172441';
    private const USER_NAME = 'root';
    private const PASSWORD = '';
    private const CHARSET = 'utf8mb4';
    private const DSN = "mysql:host=" . self::HOST_NAME . "; dbname=" . self::DATABASE . "; charset=" . self::CHARSET . ";";
    private const DBOPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Utilisation du trait de gestion des mots de passe
    use PasswordManager;

    // Connection à la BDD suivant les directives du server

    /**
     *
     */
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

    /**
     * @return mixed
     */
    protected function getDbConnection() {
        if (self::$_dbConnection === null) {
            self::setDbConnection();
        }
        return self::$_dbConnection;
    }

    // Vérifie et effectue connection à la BDD, récupère les données de la table et les intègre dans de nouveaux objets

    /**
     * @param $table
     * @param $object
     * @param $order
     * @param $where
     * @return array
     */
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

    /**
     * Fonctions du CRUD
     *
     * @param $id
     */
    protected function dropPost($id) {
        $this->getDbConnection();

        $deletePost = self::$_dbConnection->prepare('
            DELETE FROM 
                `Posts`
            WHERE 
                `id` = :id
        ') or die(print_r(self::$_dbConnection->errorInfo()));
        $deletePost->bindParam(':id', $id);

        $deletePost->execute();
        $deletePost->closeCursor();
    }

    /**
     * @param $title
     * @param $content
     * @param $urlImage
     */
    protected function newPost($title, $content, $urlImage) {
        $this->getDbConnection();

        $insertPost = self::$_dbConnection->prepare('
            INSERT INTO 
                `Posts` (`id`, `title`, `content`, `date_creation`, `image`)
            VALUES 
                (NULL, :title, :content, NOW(), :image)
        ');
        $insertPost->bindParam(':title', $title);
        $insertPost->bindParam(':content', $content);
        $insertPost->bindParam(':image', $urlImage);

        $insertPost->execute();
        $insertPost->closeCursor();
    }

    /**
     * @param $title
     * @param $content
     * @param $urlImage
     * @param $id
     */
    protected function updatePost($title, $content, $urlImage, $id) {
        $this->getDbConnection();

        $updatePost = self::$_dbConnection->prepare('
            UPDATE 
                `Posts` 
            SET 
                `title` = :title, `content` = :content, `image` = :image 
            WHERE 
                `id` = :id
        ');
        $updatePost->bindParam(':title', $title);
        $updatePost->bindParam(':content', $content);
        $updatePost->bindParam(':image', $urlImage);
        $updatePost->bindParam(':id', $id);

        $updatePost->execute();
        $updatePost->closeCursor();
    }

    /**
     * @param $comment
     * @param $user
     * @param $postId
     */
    protected function newComment($comment, $user, $postId) {
        $this->getDbConnection();

        $insertComment = self::$_dbConnection->prepare('
            INSERT INTO 
                `Comments` 
                (`billet_id`, `user`, `comment`, `comment_date`) 
            VALUES 
                (:billet_id, :user, :comment, UTC_TIMESTAMP())
        ');
        $insertComment->bindParam(':billet_id', $postId);
        $insertComment->bindParam(':user', $user);
        $insertComment->bindParam(':comment', $comment);

        $insertComment->execute();
        $insertComment->closeCursor();
    }

    /**
     * Change le niveau d'acceptation du commentaire
     *
     * @param $id
     * @param $level
     */
    protected function levelComment($id, $level) {
        $this->getDbConnection();

        $updateLevel = self::$_dbConnection->prepare('
            UPDATE 
                `Comments` 
            SET 
                `accepted` = :level 
            WHERE 
                `id` = :id
        ');
        $updateLevel->bindParam(':level', $level);
        $updateLevel->bindParam(':id', $id);

        $updateLevel->execute();
        $updateLevel->closeCursor();
    }

    /**
     * @param $id
     */
    protected function dropComment($id) {
        $this->getDbConnection();

        $deleteComment = self::$_dbConnection->prepare('
            DELETE FROM 
                `Comments`
            WHERE 
                `id` = :id
        ') or die(print_r(self::$_dbConnection->errorInfo()));
        $deleteComment->bindParam(':id', $id);

        $deleteComment->execute();
        $deleteComment->closeCursor();
    }


    /**
     * @param $username
     * @param $email
     * @param $password
     */
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

    /**
     * Vérification de l'existence d'un utilisateur
     *
     * @param $userName
     * @param $userEmail
     * @return string
     */
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

        $userCheck->bindParam(':user_name', $userName);
        $userCheck->bindParam(':user_email', $userEmail);

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

    /**
     * Vérification des données de l'utilisateur pour permettre la connexion
     *
     * @param $username
     * @param $password
     * @return mixed
     */
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

    /**
     * Vérification du mot de passe
     *
     * @param $username
     * @param $password
     * @return mixed
     */
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
}
