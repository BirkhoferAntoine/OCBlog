<?php

$host_name = 'db5000177647.hosting-data.io';
$database = 'dbs172441';
$user_name = 'dbu35984';
$password = '$2y$10$e.cqZR4c2/uL6nQ3HEAgg.nO8yy/loeDef/';
$connect = mysql_connect($host_name, $user_name, $password, $database);

if (mysql_errno()) {
    die('<p>La connexion au serveur MySQL a échoué: ' . mysql_error() . '</p>');
} else {
    echo '<p>Connexion au serveur MySQL établie avec succès.</p >';
}

