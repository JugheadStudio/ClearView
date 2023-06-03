<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check if the required fields are present in the $_POST array
if (!isset($_POST['id'], $_POST['profilePicture'], $_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['dateOfBirth'], $_POST['gender'], $_POST['phoneNumber'], $_POST['email'], $_POST['roomID'], $_POST['discipline'], $_POST['rate'])) {
    echo "Missing required fields.";
    exit;
}

$id = $_POST['id'];
$profilePicture = $_POST['profilePicture'];
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$dateOfBirth = $_POST['dateOfBirth'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$roomID = $_POST['roomID'];
$discipline = $_POST['discipline'];
$rate = $_POST['rate'];

// Prepare the SQL update statement
$sql = "UPDATE doctor SET profilePicture=?, username=?, password=?, name=?, surname=?, dateOfBirth=?, gender=?, phoneNumber=?, email=?, roomID=?, discipline=?, rate=? WHERE id=?";

// Prepare and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssi",
    $profilePicture,
    $username,
    $password,
    $name,
    $surname,
    $dateOfBirth,
    $gender,
    $phoneNumber,
    $email,
    $roomID,
    $discipline,
    $rate,
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
