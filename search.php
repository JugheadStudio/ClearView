<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php';

// Handle the search query based on the type (patient or doctor)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['type'] === 'patient') {
    $query = $_POST['query']; // The search query entered by the user

    // Prepare the SQL statement for patient search
    $stmt = $conn->prepare("SELECT id, name FROM patients WHERE name LIKE ?");
    $likeParam = '%' . $query . '%';
    $stmt->bind_param('s', $likeParam);
    $stmt->execute();

    // Fetch the matching patients from the database
    $result = $stmt->get_result();
    $patients = $result->fetch_all(MYSQLI_ASSOC);

    // Return the matching patients as JSON
    echo json_encode($patients);
  } else if ($_POST['type'] === 'doctor') {
    $query = $_POST['query']; // The search query entered by the user

    // Prepare the SQL statement for doctor search
    $stmt = $conn->prepare("SELECT id, name FROM doctor WHERE name LIKE ?");
    $likeParam = '%' . $query . '%';
    $stmt->bind_param('s', $likeParam);
    $stmt->execute();

    // Fetch the matching doctors from the database
    $result = $stmt->get_result();
    $doctors = $result->fetch_all(MYSQLI_ASSOC);

    // Return the matching doctors as JSON
    echo json_encode($doctors);
  }
}
?>
