<?php

abstract class MainModel {

    private static $_dbConnection;
    private const HOST_NAME = 'db5000177647.hosting-data.io';
    private const DATABASE = 'dbs172441';
    private const USER_NAME = 'dbu35984';
    private const PASSWORD = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';

    private static function setDbConnection()
    {
        try {
            echo 'try';
            $host_name = 'db5000177647.hosting-data.io';
            $database = 'dbs172441';
            $user_name = 'dbu35984';
            $password = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';
            self::$_dbConnection = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            echo 'try';
        }
        catch (PDOException $e) {
            echo "Erreur!: " . $e->getMessage() . "<br/>";
            die();
        };
    }

    protected function getDbConnection() {
        if (self::$_dbConnection = null) {
            self::setDbConnection();
            return self::$_dbConnection;
        }
    }

    protected function getAll($table, $object) {
            $tableContent = [];
            self::setDbConnection();
            $tableQuery = self::$_dbConnection->prepare('SELECT * FROM ' . $table . ' ORDER BY id DESC');
            $tableQuery->execute();
            while ($tableQueryData = $tableQuery->fetch(PDO::FETCH_ASSOC)){
                $tableContent[] = new $object($tableQueryData);
                echo $tableContent;
            }
            $tableQuery->closeCursor();
            echo 'lala';
            return $tableContent;

    }

};
/*
if(isset($_dbConnection)) {

    $dataListPosts = $_dbConnection->query('SELECT id, content, title, date_creation FROM `Posts` ORDER BY id DESC') or die(print_r($_dbConnection->errorInfo()));
            if (isset($dataListPosts)) {
                while($listPosts = $dataListPosts->fetch()) {
                    print_r($listPosts);
                };
            }

}

$postTitle = $listPosts['title']; */