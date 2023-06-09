<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$profilePicture = $_FILES['profilePicture']['name'];
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

// Check if a file is uploaded, otherwise set the profile picture to the placeholder image
if ($_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    // Get the file extension
    $fileExtension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
    // Generate a unique filename
    $filename = uniqid() . '.' . $fileExtension;
    // Set the target file path
    $targetFile = 'uploads/' . $filename;
} else {
    // Set the profile picture to the placeholder image
    $targetFile = 'uploads/placeholder.png';
}

$sql = "INSERT INTO `patients`(`profilePicture`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `address`, `medicalAid`, `medicalAidNumber`, `bloodType`, `allergy`, `EmergencyContactName`, `EmergencyContactNumber`) VALUES ('$targetFile', '$name', '$surname', '$dateOfBirth', '$gender', '$phoneNumber', '$email', '$address', '$medicalAid', '$medicalAidNumber', '$bloodType', '$allergy', '$emergencyContactName', '$emergencyContactNumber')";

if ($conn->query($sql) === TRUE) {
    echo 'Data inserted successfully';
} else {
    echo 'Error inserting data: ' . $conn->error;
}

$conn->close();

// Handle file upload
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['profilePicture']['tmp_name'];

    // Move the uploaded file to the desired location
    if (move_uploaded_file($tempFile, $targetFile)) {
        echo "File uploaded successfully.";
    } else {
        echo "File upload failed.";
    }
} else {
    echo "No file uploaded or upload error occurred.";
}

// Redirect to index.php
header('Location: index.php');
exit();
?>
