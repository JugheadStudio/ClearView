<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$profilePicture = $_FILES['profilePicture']['name'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$roomID = $_POST['roomID'];
$discipline = $_POST['discipline'];
$rate = $_POST['rate'];

// Get the file extension
$fileExtension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
// Generate a unique filename
$filename = uniqid() . '.' . $fileExtension;
// Set the target file path
$targetFile = 'uploads/' . $filename;

$sql = "INSERT INTO doctor (username, password, profilePicture, name, surname, dateOfBirth, gender, phoneNumber, email, roomID, discipline, rate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssss",
    $username,
    $password,
    $targetFile,
    $name,
    $surname,
    $dateOfBirth,
    $gender,
    $phoneNumber,
    $email,
    $roomID,
    $discipline,
    $rate
);

if ($stmt->execute()) {
    echo 'Data inserted successfully';
} else {
    echo 'Error inserting data: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Handle file upload
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['profilePicture']['tmp_name'];

    // Move the uploaded file to the desired location
    if (move_uploaded_file($tempFile, $targetFile)) {
        // File upload success
        echo "File uploaded successfully.";
        // Perform further processing or database storage here
    } else {
        // File upload failed
        echo "File upload failed.";
    }
} else {
    // No file uploaded or upload error occurred
    echo "No file uploaded or upload error occurred.";
}

// Redirect to index.php
header('Location: index.php');
exit();
?>
