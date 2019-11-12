<?php
    //Classe abstraite car sert uniquement à accèder a la BDD
abstract class MainModel {

    private static $_dbConnection;
    private const HOST_NAME = 'db5000177647.hosting-data.io';
    private const DATABASE = 'dbs172441';
    private const USER_NAME = 'dbu35984';
    private const PASSWORD = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';

    // Connection à la BDD suivant les directives du server
    private static function setDbConnection()
    {
        try {
            self::$_dbConnection = new PDO("mysql:host=" . self::HOST_NAME . "; dbname=" . self::DATABASE . ";", self::USER_NAME, self::PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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
        $this->getDbConnection();
        $tableContent = [];
        $tableQuery = self::$_dbConnection->prepare('SELECT * FROM ' . $table . $orderSelect . $whereSelect) or die(print_r(self::$_dbConnection->errorInfo()));
        print_r($tableQuery);
        $tableQuery->execute();
        if (isset($tableQuery)) {
            while ($tableQueryData = $tableQuery->fetch(PDO::FETCH_ASSOC)){
                $tableContent[] = new $object($tableQueryData);
            }
        }
        $tableQuery->closeCursor();
        return $tableContent;
    }
};