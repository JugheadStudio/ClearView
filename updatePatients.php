<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$profilePicture = $_POST['profilePicture'];

$sql = "UPDATE `patients` SET `name`='$name',`surname`='$surname',`profilePicture`='$profilePicture' WHERE `id`='$id'";

if ($conn->query($sql) === TRUE) {
    echo 'Data updated successfully';
} else {
    echo 'Error updating data: ' . $conn->error;
}

$conn->close();
?>
