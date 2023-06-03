<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$id = $_POST['id'];
$profilePicture = $_POST['profilePicture'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$medicalAid = $_POST['medicalAid'];
$medicalAidNumber = $_POST['medicalAidNumber'];
$bloodType = $_POST['bloodType'];
$allergy = $_POST['allergy'];
$emergencyContactName = $_POST['emergencyContactName'];
$emergencyContactNumber = $_POST['emergencyContactNumber'];

// Prepare the SQL update statement
$sql = "UPDATE patients SET name=?, surname=?, dateOfBirth=?, gender=?, phoneNumber=?, email=?, medicalAid=?, medicalAidNumber=?, bloodType=?, allergy=?, emergencyContactName=?, emergencyContactNumber=?, profilePicture=? WHERE id=?";

// Prepare and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(
	"sssssssssssssi",
	$name,
	$surname,
	$dateOfBirth,
	$gender,
	$phoneNumber,
	$email,
	$medicalAid,
	$medicalAidNumber,
	$bloodType,
	$allergy,
	$emergencyContactName,
	$emergencyContactNumber,
	$profilePicture,
	$id
);

// Execute the update statement
if ($stmt->execute()) {
	echo 'Data updated successfully';
} else {
	echo 'Error updating data: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect to index.php
header('Location: index.php');
exit();
?>
<!--  -->