<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$sql = "INSERT INTO `patients`(`id`, `profilePicture`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `address`, `medicalAid`,`medicalAidNumber`, `bloodType`, `allergy`, `EmergencyContactName`, `EmergencyContactNumber`) VALUES ('$id','$profilePicture','$name','$surname','$dateOfBirth','$gender','$phoneNumber','$email','$address','$medicalAid','$medicalAidNumber','$bloodType','$allergy','$emergencyContactName','$emergencyContactNumber')";

if ($conn->query($sql) === TRUE) {
    echo 'Data inserted successfully';
} else {
    echo 'Error inserting data: ' . $conn->error;
}

$conn->close();

header('Location: index.php');
?>
