<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$patientID = $_POST['patientID'];
$doctorID = $_POST['doctorID'];
$roomID = $_POST['roomID'];
$date = $_POST['date'];
$time = $_POST['time'];

// Insert the appointment data into the database
$sql = "INSERT INTO appointment (patientID, doctorID, roomID, date, time)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiss", $patientID, $doctorID, $roomID, $date, $time);

if ($stmt->execute()) {
  echo 'Data inserted successfully';
} else {
  echo 'Error inserting data: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect to index.php after successful appointment creation
header('Location: index.php');
exit();
?>
