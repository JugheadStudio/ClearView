<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and any required functions
include '../db.php';

// Retrieve the token from the URL parameter
$resetToken = isset($_GET['token']) ? $_GET['token'] : '';


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the new password from the form submission
    $newPassword = $_POST['newPassword'];

    if ($resetToken !== '') {
      // Retrieve the user's information from the database using the token
      $sql = "SELECT * FROM passwordResetTokens WHERE resetToken = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $resetToken);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($stmt->errno) {
          // Database query error
          echo "Database query error: " . $stmt->error;
          exit();
      }
  
      if ($result->num_rows == 1) {
          // Token exists, retrieve the user's ID
          $row = $result->fetch_assoc();
          $userId = $row['userID'];
  
          // Verify the token and check its expiration (implement your own logic)
  
          if ($row['resetToken'] === $resetToken) {
              // Update the user's password in the database
              $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
              $sql = "UPDATE receptionist SET password = ? WHERE id = ?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("si", $hashedPassword, $userId);
              $stmt->execute();
  
              if ($stmt->errno) {
                // Database update error
                echo "Database update error: " . $stmt->error;
                exit();
            } elseif ($stmt->affected_rows > 0) {
                // Password updated successfully
                echo "Your password has been successfully reset. You can now log in with your new password.";
                exit();
            } else {
                // Failed to update the password
                echo "Failed to reset your password. Please try again later.";
                exit();
            }
            
          } else {
              // Invalid token
              echo "Invalid token. Please try again.";
              exit();
          }
      } else {
          // Invalid or expired token
          echo "Invalid token. Please try again.";
          exit();
      }
  } else {
      // Token not provided
      echo "Invalid token. Please try again.";
      exit();
  }
  
} else {
    // No form submission, display the reset password form
?>
    <!-- HTML form for entering the new password -->
    <form method="POST" action="resetPassword.php?token=<?php echo $resetToken; ?>">
        <input type="password" name="newPassword" placeholder="New Password" required>
        <button type="submit">Reset Password</button>
    </form>
<?php
}
?>
