<?php
include 'db.php';

$name = $_POST["name"];
$surname = $_POST["surname"];

$sql = "INSERT INTO patients (name, surname) VALUES ('$name', '$surname')";

$conn->query($sql);

$conn->close();

header("location: index.php");
?>
