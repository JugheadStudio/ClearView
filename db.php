

<?php
$host = "localhost";  // Hostname of the MySQL server
$username = "root";  // Username to access the database
$password = "";  // Password to access the database
$database = "ClearView";  // Name of the database

// Create a new MySQLi object and establish a connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
