<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$profilePicture = $_POST['profilePicture'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$address = $_POST['address'];
$medicalAid = $_POST['medicalAid'];
$medicalAidNumber = $_POST['medicalAidNumber'];
$bloodType = $_POST['bloodType'];
$allergy = $_POST['allergy'];
$emergencyContactName = $_POST['emergencyContactName'];
$emergencyContactNumber = $_POST['emergencyContactNumber'];

$sql = "UPDATE `patients` SET `id`='$id', `profilePicture`='$profilePicture', `name`='$name', `surname`='$surname', `dateOfBirth`='$dateOfBirth', `gender`='$gender', `phoneNumber`='$phoneNumber', `email`='$email', `address`='$address', `medicalAid`='$medicalAid', `medicalAidNumber`='$medicalAidNumber', `bloodType`='$bloodType', `allergy`='$allergy', `emergencyContactName`='$emergencyContactName', `emergencyContactNumber`='$emergencyContactNumber' WHERE `id`='$id'";

if ($conn->query($sql) === TRUE) {
    echo 'Data updated successfully';
} else {
    echo 'Error updating data: ' . $conn->error;
}

$conn->close();
?>
