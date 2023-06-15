<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check if the required fields are present in the $_POST array
if (!isset($_POST['id'], $_POST['patientID'], $_POST['doctorID'], $_POST['roomID'], $_POST['date'], $_POST['time'])) {
  echo "Missing required fields.";
  exit;
}

$patientID = $_POST['patientID'];
$doctorID = $_POST['doctorID'];
$roomID = $_POST['roomID'];
$date = $_POST['date'];
$time = $_POST['time'];

// Prepare the SQL update statement
$sql = "UPDATE appointment SET profilePicture=?, patientID=?, doctorID=?, roomID=?, date=?, time=? WHERE id=?";

// Prepare and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(
  "iiissi",
  $patientID,
  $doctorID,
  $roomID,
  $date,
  $time,
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