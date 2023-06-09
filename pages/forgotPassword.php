<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and any required functions
include '../db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the username or email from the form
  $usernameOrEmail = $_POST['usernameOrEmail'];

  // Validate the username or email (check if it exists in the database)
  $sql = "SELECT * FROM receptionist WHERE username = ? OR email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    // User exists, generate a unique password reset token
    $resetToken = generateResetToken();

    // Get the user's ID
    $row = $result->fetch_assoc();
    $userId = $row['id'];

    // Store the token and the user's ID in the database
    storeResetToken($userId, $resetToken);

    // Send the password reset email to the user
    $emailSent = sendPasswordResetEmail($row['email'], $resetToken);

    if ($emailSent) {
      // Display a success message
      echo "Password reset email has been sent to your registered email address.";
    } else {
      // Display an error message if the email sending failed
      echo "Failed to send the password reset email. Please try again later.";
    }
    exit();
  } else {
    // User does not exist, display an error message
    echo "User does not exist.";
    exit();
  }
}

function generateResetToken()
{
  // Generate a random token using a combination of letters, numbers, and symbols
  $token = bin2hex(random_bytes(32));

  return $token;
}

function storeResetToken($userID, $resetToken)
{
  global $conn;

  // Prepare the SQL statement
  $sql = "INSERT INTO passwordResetTokens (userID, resetToken) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    // Error in preparing the statement, handle it accordingly
    die("Error: " . $conn->error);
  }

  // Bind the parameters and execute the statement
  $stmt->bind_param("is", $userID, $resetToken);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    // Token stored successfully
    return true;
  } else {
    // Failed to store the token
    return false;
  }
}

function sendPasswordResetEmail($email, $resetToken)
{
  // SendGrid API endpoint URL
  $url = "https://api.sendgrid.com/v3/mail/send";

  // SendGrid API key
  $apiKey = "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";

  // Compose the email data
  $emailData = [
    "personalizations" => [
      [
        "to" => [
          [
            "email" => $email
          ]
        ]
      ]
    ],
    "from" => [
      "email" => "150139@virtualwindow.co.za"
    ],
    "subject" => "Password Reset",
    "content" => [
      [
        "type" => "text/html",
        "value" => "Please click the following link to reset your password: <a href='http://localhost/ClearView/pages/resetPassword.php?token=$resetToken'>Reset Password</a>"
      ]
    ]
  ];

  // Send the email using SendGrid API
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
  ]);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($emailData));
  $response = curl_exec($curl);
  curl_close($curl);

  // Check the response and return true if the email is sent successfully
  return $response !== false;
}

?>
<!-- HTML form for requesting password reset -->
<form action="forgotPassword.php" method="POST">
  <div class="form-group">
    <label for="usernameOrEmail">Username or Email:</label>
    <input type="text" id="usernameOrEmail" name="usernameOrEmail" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Reset Password</button>
</form>