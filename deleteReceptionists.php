<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$id = $_GET['id'];

// Retrieve the profile picture path before deleting the patient
$sql = "SELECT profilePicture FROM receptionist WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();

// Delete token entries for the receptionist from passwordResetTokens table
$sqlDeleteTokens = "DELETE FROM passwordResetTokens WHERE userID = ?";
$stmtDeleteTokens = $conn->prepare($sqlDeleteTokens);
$stmtDeleteTokens->bind_param('i', $id);

// Delete receptionist from the receptionist table
$sqlDeleteReceptionist = "DELETE FROM receptionist WHERE id = ?";
$stmtDeleteReceptionist = $conn->prepare($sqlDeleteReceptionist);
$stmtDeleteReceptionist->bind_param('i', $id);

// Perform the deletion operations
$conn->begin_transaction();

try {
    // Delete token entries
    $stmtDeleteTokens->execute();

    // Delete the profile picture if it exists and is not the placeholder image
    if ($profilePicture !== null && $profilePicture !== 'uploads/placeholder.png') {
        if (file_exists($profilePicture)) {
            unlink($profilePicture);
        }
    }

    // Delete receptionist
    $stmtDeleteReceptionist->execute();

    $conn->commit();
    echo "Record, related token entries, and profile picture deleted successfully";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error deleting record: " . $e->getMessage();
}

$stmtDeleteTokens->close();
$stmtDeleteReceptionist->close();
$conn->close();
header("location: index.php");
?>
