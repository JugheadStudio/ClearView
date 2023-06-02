<?php
// Check if a file was uploaded successfully
if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['profilePicture']['tmp_name'];
    $targetDirectory = 'uploads/'; // Change this to your desired upload directory
    $targetFile = $targetDirectory . $_FILES['profilePicture']['name'];

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
?>
