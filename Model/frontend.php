<?php


$host_name = 'db5000177647.hosting-data.io';
$database = 'dbs172441';
$user_name = 'dbu35984';
$password = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';
$dbh = null;

try {
    $dbh = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (PDOException $e) {
    echo "Erreur!: " . $e->getMessage() . "<br/>";
    die();
};

if(isset($dbh)) {

    $dataListPosts = $dbh->query('SELECT id, content, title, date_creation FROM `Posts` ORDER BY id DESC') or die(print_r($dbh->errorInfo()));
            if (isset($dataListPosts)) {
                $listPosts = $dataListPosts->fetch();
            }

}
