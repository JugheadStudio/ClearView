<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];

$sql = "UPDATE patients SET name = '$name', surname = '$surname' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo 'Data updated successfully';
} else {
    echo 'Error updating data: ' . $conn->error;
}

$conn->close();
?>
