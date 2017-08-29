<?php

function connect() {
    require_once('config.php');
    $conn = mysqli_connect($config['dbhost'], $config['dbuser'], $config['dbpass']) or die(mysql_error());
    mysqli_select_db($conn,$config['dbname']) or die(mysql_error());
    return $conn;
}

function disconnect($conn) {
    require_once('config.php');
    mysqli_close($conn);
}
?>