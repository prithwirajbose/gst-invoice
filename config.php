<?php
$config = array();
$config['dbhost']="localhost";
$config['dbuser']="root";
$config['dbpass']="9883246001";
$config['dbname']="gstinvoicedb";
$config['site']="http://localhost/gst-invoice";

function connect() {
    global $config;
    $conn = mysqli_connect($config['dbhost'], $config['dbuser'], $config['dbpass']) or die("Unable to connect to Database. Incorrect username or password.");
    mysqli_select_db($conn,$config['dbname']) or die(mysqli_error($conn));
    return $conn;
}

function disconnect($conn) {
    mysqli_close($conn);
}
?>