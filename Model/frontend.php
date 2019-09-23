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

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8"/>
        <meta name="author" content="Antoine Birkhofer"/>

        <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <title>"Password"</title>

    </head>

    <style>
        form {
            text-align: center;
        }
    </style>

<body>

<?php

if(isset($dbh)) {
    $reponse = $dbh->query('SELECT id, content, title, date_creation FROM `Posts`') or die(print_r($dbh->errorInfo()));

    ?>
    <pre>
        <?php
        print_r($reponse);
        ?>
        </pre>
    <?php
    if (isset($reponse)) {
        print_r($reponse);
    }
    while ($data = $reponse->fetch()) {
        print_r($data);
        echo $data;
    };
}




?>