<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check if the required fields are present in the $_POST array
if (
  !isset($_POST['id'], $_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['gender'], $_POST['phoneNumber'], $_POST['email'], $_POST['rank'])
) {
  echo "Missing required fields.";
  exit;
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$rank = $_POST['rank'];

// Check if a new image is uploaded
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['size'] > 0) {
  $uploadDir = 'uploads/'; // Directory where uploaded images are stored
  $uploadedFile = $_FILES['profilePicture']['tmp_name'];
  $fileExtension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
  $fileName = uniqid() . '.' . $fileExtension;
  $targetPath = $uploadDir . $fileName;

  // Move the uploaded file to the desired location
  if (move_uploaded_file($uploadedFile, $targetPath)) {
    // Delete the previous image if it exists
    $sql = "SELECT profilePicture FROM receptionist WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($existingProfilePicture);
    $stmt->fetch();
    $stmt->close();

    if ($existingProfilePicture !== null && $existingProfilePicture !== 'uploads/placeholder.png') {
      if (file_exists($existingProfilePicture)) {
        unlink($existingProfilePicture);
      }
    }

    $profilePicture = $targetPath;
  } else {
    // Update with the appropriate placeholer image
    $profilePicture = $uploadDir . 'placeholder.png';
  }
} else {
  // No new image uploaded, retrieve the existing image path from the database
  $sql = "SELECT profilePicture FROM receptionist WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->bind_result($existingProfilePicture);
  $stmt->fetch();
  $stmt->close();

  $profilePicture = $existingProfilePicture;
}

// Check if a new password is provided
if (!empty($password)) {
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
} else {
  // Retrieve the existing hashed password from the database
  $sql = "SELECT password FROM receptionist WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->bind_result($existingPassword);
  $stmt->fetch();
  $stmt->close();

  $hashedPassword = $existingPassword;
}

// Prepare the SQL update statement
$sql = "UPDATE receptionist SET profilePicture=?, username=?, password=?, name=?, surname=?, dateOfBirth=?, gender=?, phoneNumber=?, email=?, rank=? WHERE id=?";

// Prepare and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "ssssssssssi",
  $profilePicture,
  $username,
  $hashedPassword,
  $name,
  $surname,
  $dateOfBirth,
  $gender,
  $phoneNumber,
  $email,
  $rank,
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