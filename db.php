<?php
// Include the config file
require_once('config/config.php');

$host = CLEARVIEW_HOST;  // Hostname of the MySQL server
$username = CLEARVIEW_USERNAME;  // Username to access the database
$password = CLEARVIEW_PASSWORD;  // Password to access the database
$database = CLEARVIEW_DATABASE;  // Name of the database

// Create a new MySQLi object and establish a connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>