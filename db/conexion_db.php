<?php
require('db_info.php');
function connectBBDD(): bool|PDO
{
    $hostname = DB_HOST;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $database = DB_NAME;
    $conn = false;
    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
       header('Location: ' . $GLOBALS['root'].'error/pagina_error.php');
    }
    return $conn;
}?>