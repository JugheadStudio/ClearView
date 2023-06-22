<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
$name = $_POST['name'];
$surname = $_POST['surname'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$rank = $_POST['rank'];

// Check if a profile picture is selected
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $profilePicture = $_FILES['profilePicture']['name'];

    // Get the file extension
    $fileExtension = pathinfo($profilePicture, PATHINFO_EXTENSION);
    // Generate a unique filename
    $filename = uniqid() . '.' . $fileExtension;
    // Set the target file path
    $targetFile = 'uploads/' . $filename;

    // Handle file upload
    if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
        // File upload success
        echo "File uploaded successfully.";
    } else {
        // File upload failed
        echo "File upload failed.";
    }
} else {
    // No profile picture selected, use placeholder image
    $targetFile = 'uploads/placeholder.png'; // Update with the path to your placeholder image
}

$stmt = $conn->prepare("INSERT INTO `receptionist` (`profilePicture`, `username`, `password`, `name`, `surname`, `dateOfBirth`, `gender`, `phoneNumber`, `email`, `rank`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $targetFile, $username, $hashedPassword, $name, $surname, $dateOfBirth, $gender, $phoneNumber, $email, $rank);

if ($stmt->execute()) {
    echo 'Data inserted successfully';
} else {
    echo 'Error inserting data: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect to index.php
header('Location: index.php');
exit();
?>
