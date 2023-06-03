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
$medicalAid = $_POST['medicalAid'];
$medicalAidNumber = $_POST['medicalAidNumber'];
$bloodType = $_POST['bloodType'];
$allergy = $_POST['allergy'];
$emergencyContactName = $_POST['emergencyContactName'];
$emergencyContactNumber = $_POST['emergencyContactNumber'];

// Prepare the SQL update statement
$sql = "UPDATE patients SET profilePicture=?, name=?, surname=?, dateOfBirth=?, gender=?, phoneNumber=?, email=?, medicalAid=?, medicalAidNumber=?, bloodType=?, allergy=?, emergencyContactName=?, emergencyContactNumber=? WHERE id=?";

// Prepare and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "sssssssssssssi",
  $profilePicture,
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
?>
