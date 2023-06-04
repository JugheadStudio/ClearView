<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page
header("location: ../index.php");
exit();
?>
