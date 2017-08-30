<?php

function connect() {
    require_once('config.php');
    $conn = mysqli_connect($config['dbhost'], $config['dbuser'], $config['dbpass']) or die("Unable to connect to Database. Incorrect username or password.");
    mysqli_select_db($conn,$config['dbname']) or die(mysqli_error($conn));
    return $conn;
}

function disconnect($conn) {
    require_once('config.php');
    mysqli_close($conn);
}
?>