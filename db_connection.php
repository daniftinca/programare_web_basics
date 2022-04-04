<?php

$host = "localhost";
$username = "root";
$password = "";
$dbName = "uni_db";

$mysqli = new mysqli("localhost", "root", "", "uni_db");


// Check connection
$connected = true;
$error = "";
if ($mysqli->connect_errno) {
    $connected = false;
    $error = $mysqli->connect_error;
}


if ($connected) {
    ?>
    <h1>Conectat cu succes!</h1>
    <h3>Infos: </h3>
    <div>Host: <?php echo $host ?></div>
    <div>Username: <?php echo $username ?></div>
    <div>Password: <?php echo $password ?></div>
    <div>DbName: <?php echo $dbName ?></div>
    <?php
} else {
    ?>
    <h1>Nu s-a putut conecta :( </h1>
    <h3>Eroare: </h3>
    <div> <?php echo $error ?></div>
    <?php
}


?>