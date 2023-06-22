<?php
include 'db.php';

$id = $_GET['id'];

// Retrieve the profile picture path before deleting the patient
$sql = "SELECT profilePicture FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();

// Delete the patient from the database
$sql = "DELETE FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $stmt->error;
}
$stmt->close();

// Delete the profile picture if it exists and is not the placeholder image
if ($profilePicture !== null && $profilePicture !== 'uploads/placeholder.png' && file_exists($profilePicture)) {
    unlink($profilePicture);
}

$conn->close();
header("location: index.php");
?>
