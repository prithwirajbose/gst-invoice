<?php
if(!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php?redir=".$_SERVER['PHP_SELF']);
}

if(isset($GLOBALS["__LEVEL"]) && $_SESSION['user']['access_level']>$GLOBALS["__LEVEL"]) {
    http_response_code(403);
    die('You are not authorized to access this page!');
}
?>