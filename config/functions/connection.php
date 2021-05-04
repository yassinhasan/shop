<?php

$dsn = "mysql:dbname=shop;host=localhost";
$user = "root";
$password = "hasan123";
$option = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
);


try{
$conn = new PDO($dsn, $user, $password, $option);

}
catch(PDOException $e)
{

    echo "<p class='alert alert-danger'> failed to connect to $dbname ".$e->getMessage() ."</p>";

}