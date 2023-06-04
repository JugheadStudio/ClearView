<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check if the required fields are present in the $_POST array
if (
	isset($_POST['id'], $_POST['profilePicture'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['gender'], $_POST['phoneNumber'], $_POST['email'], $_POST['address'], $_POST['medicalAid'], $_POST['medicalAidNumber'], $_POST['bloodType'], $_POST['allergy'], $_POST['emergencyContactName'], $_POST['emergencyContactNumber'])
) {
	$id = $_POST['id'];
	$profilePicture = $_POST['profilePicture'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
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

	// Prepare the SQL update statement
	$sql = "UPDATE patients SET profilePicture=?, name=?, surname=?, dateOfBirth=?, gender=?, phoneNumber=?, email=?, address=?, medicalAid=?, medicalAidNumber=?, bloodType=?, allergy=?, emergencyContactName=?, emergencyContactNumber=? WHERE id=?";

	// Prepare and bind the parameters
	$stmt = $conn->prepare($sql);
	$stmt->bind_param(
		"ssssssssssssssi",
		$profilePicture,
		$name,
		$surname,
		$dateOfBirth,
		$gender,
		$phoneNumber,
		$email,
		$address,
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

	// Redirect to index.php
	header('Location: index.php');
	exit();
} else {
	echo "Missing required fields.";
}
?>