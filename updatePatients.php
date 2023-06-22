<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check if the required fields are present in the $_POST array
if (
  isset($_POST['id'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['gender'], $_POST['phoneNumber'], $_POST['email'], $_POST['address'], $_POST['medicalAid'], $_POST['medicalAidNumber'], $_POST['bloodType'], $_POST['allergy'], $_POST['emergencyContactName'], $_POST['emergencyContactNumber'])
) {
  $id = $_POST['id'];
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

  // Check if a new image is uploaded
  if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['size'] > 0) {
    $uploadDir = 'uploads/'; // Directory where uploaded images are stored
    $uploadedFile = $_FILES['profilePicture']['tmp_name'];
    $fileExtension = pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $fileExtension;
    $targetPath = $uploadDir . $fileName;

    // Delete the previous image
    $sql = "SELECT profilePicture FROM patients WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($existingProfilePicture);
    $stmt->fetch();
    $stmt->close();

    if ($existingProfilePicture != 'uploads/placeholder.png') {
      // Delete the previous image file
      unlink($existingProfilePicture);
    }

    // Move the uploaded file to the desired location
    if (move_uploaded_file($uploadedFile, $targetPath)) {
      $profilePicture = $targetPath;
    } else {
      // Handle the case when the file couldn't be uploaded
      // For example, you can assign a default image to the employee
      $profilePicture = $uploadDir . 'placeholder.png'; // Update with the appropriate default image name
    }
  } else {
    // No new image uploaded, retrieve the existing image path from the database
    $sql = "SELECT profilePicture FROM patients WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($existingProfilePicture);
    $stmt->fetch();
    $stmt->close();

    $profilePicture = $existingProfilePicture;
  }

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
  $missingFields = array();
  $requiredFields = array(
    'id',
    'name',
    'surname',
    'dateOfBirth',
    'gender',
    'phoneNumber',
    'email',
    'address',
    'medicalAid',
    'medicalAidNumber',
    'bloodType',
    'allergy',
    'emergencyContactName',
    'emergencyContactNumber'
  );

  foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
      $missingFields[] = $field;
    }
  }

  echo 'Missing required fields: ' . implode(', ', $missingFields);
}
?>
