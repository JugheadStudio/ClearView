<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and any required functions
include '../db.php';

// Include the config file
require_once('../config/config.php');

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
      // Success: Display a success message
      $successMessage = "Password reset email has been sent.";
    } else {
      // Error: Display an error message if the token storing or email sending failed
      $errorMessage = "Failed to send the password reset email. Please try again later.";
    }
  } else {
    // User does not exist, display an error message
    $errorMessage = "User does not exist.";
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
  $apiKey = SENDGRID_API_KEY;

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
        "value" => "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Email Template</title>
        </head>
        <body bgcolor='#EFEFEF' style='margin: 0; padding: 0; font-family: Montserrat, sans-serif;'>
          <table cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;'>
            <tr>
              <td align='center' style='padding: 20px; font-family: Montserrat, sans-serif;'>
                <table cellpadding='0' cellspacing='0' width='850' style='border-collapse: collapse; background-color: #ffffff;'>
                  <tr>
                    <td>
                      <a href=''>
                        <img src='https://github.com/JugheadStudio/Github-assets/blob/main/ClearView/mailer-header.jpg?raw=true' alt=''>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td style='padding: 20px; text-align: center;'>
                      <h3>You have requested to reset your password</h3>
                      <p>Click on the button below to reset your password</p>
  
                      <a href='http://localhost/ClearView/pages/resetPassword.php?token=$resetToken'>
                        <img src='https://github.com/JugheadStudio/Github-assets/blob/main/ClearView/reset-button.png?raw=true' alt=''>
                      </a>
  
                      <p>If you did not request to reset your password, please ignore this email.</p>
  
                      <br>
                      <br>
                      <br>
                      <br>
                    </td>
                  </tr>
  
                  <tr>
                    <td>
                      <a href=''>
                        <img src='https://github.com/JugheadStudio/Github-assets/blob/main/ClearView/mailer-footer.jpg?raw=true' alt=''>
                      </a>
                    </td>
                  </tr>
  
                </table>
              </td>
            </tr>
          </table>
        </body>
        </html>"
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ClearView - Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>

<body class=login-body>

  <div class="container">
    <div class="row justify-content-center login-wrapper">
      <div class="col-4 login-container">
        <div class="login-form">

          <div class="login-logo">
            <svg viewBox="0 0 182 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M13.5345 1.47106C10.628 1.47106 7.69314 6.45757 7.69314 12.6408C7.69314 18.7956 9.77322 23.8106 13.1355 23.8106H13.7624C17.4952 23.7821 19.5753 19.508 20.3161 17.4849V24.4945H11.2834C5.32811 24.4945 0.512573 19.1945 0.512573 12.6408C0.512573 9.36398 1.70933 6.42907 3.64695 4.292C5.55606 2.15493 8.23453 0.815695 11.1979 0.787201H20.3161V7.7968C19.5753 5.7737 17.4952 1.47106 13.7339 1.47106H13.5345Z" fill="currentColor" />
              <path d="M30.0672 22.4144C30.0672 23.2692 30.5231 24.067 31.2924 24.4945H21.6329C22.4022 24.067 22.8581 23.2692 22.8581 22.3859V4.94737C22.8581 3.63663 21.6613 3.12373 21.6613 3.12373H21.6329C21.6329 3.12373 26.7048 2.43987 30.0672 0.787201V22.4144Z" fill="currentColor" />
              <path d="M48.1838 6.57154C49.6655 6.57154 50.7482 7.14143 51.8025 8.05325C53.7116 9.70592 53.9966 14.6639 49.9219 14.6639H43.2257H38.6097C38.5812 14.9489 38.5527 15.2338 38.5527 15.5188C38.5527 20.1063 41.5161 23.8106 43.9381 23.8106H45.5053C49.2665 23.8106 51.3466 19.508 52.0875 17.4849V24.4945H40.3193C35.3613 24.4945 31.3721 20.4768 31.3721 15.5188C31.3721 10.5892 35.3613 6.57154 40.3193 6.57154H48.1838ZM46.4741 10.8172C46.7875 9.59194 46.5881 8.33819 45.3628 7.54035C44.8499 7.19842 44.28 7.25541 43.8811 7.25541C41.7155 7.34089 39.2365 10.2188 38.6667 13.9801H42.143C44.1376 13.9801 45.9612 12.7263 46.4741 10.8172Z" fill="currentColor" />
              <path d="M73.59 22.4144C73.59 23.2692 74.0459 24.067 74.7867 24.4945H59.8272C56.1515 24.4945 53.1881 21.4456 53.302 17.7413C53.3875 14.151 56.5219 11.4156 60.1122 11.4156C60.1122 11.4156 60.1407 11.4156 60.2261 11.4156C60.7106 11.4156 62.6197 11.4726 64.3578 12.4414C65.0987 12.8403 65.8395 13.4387 66.3809 14.265V10.1903C66.3809 9.36398 66.0675 8.62313 65.5261 8.11023C64.6998 7.31239 63.4175 6.94197 62.1353 7.51185C61.1095 7.99626 60.796 9.53495 62.1353 10.1903H60.4826H56.4364C55.3251 10.1903 54.6698 8.87958 55.3821 8.02475C56.2654 6.99896 57.6047 6.57154 59.0864 6.57154H68.7744C71.4244 6.57154 73.59 8.70862 73.59 11.3586V22.4144ZM66.3809 23.8106V16.2881C66.3809 15.5188 66.0675 14.8064 65.4976 14.2935C65.4691 14.2935 65.4691 14.2935 65.4406 14.265C64.0444 13.0682 61.9073 13.5242 61.081 15.1768C60.7105 15.9462 60.4256 16.972 60.4826 18.3112C60.6251 21.3886 63.2465 23.8106 66.3524 23.8106H66.3809Z" fill="currentColor" />
              <path d="M89.226 6.57154C90.7077 6.57154 91.7905 7.14143 92.8163 8.05325C94.7254 9.70592 95.0103 14.6639 90.9641 14.6639H84.5244C85.8922 14.2935 87.6873 12.1849 87.6303 10.0763C87.6018 8.7656 86.3196 7.82529 85.1228 8.36668C84.439 8.68012 83.7266 9.16452 83.3277 9.90538V22.4144C83.3277 23.2977 83.7836 24.067 84.5529 24.4945H74.8649C75.6342 24.067 76.1186 23.2977 76.1186 22.4144V8.65163C76.1186 8.11023 75.9192 7.62583 75.5202 7.22691L74.8649 6.57154H83.3277V8.7656C83.3277 8.7656 84.0115 7.91077 85.5217 7.25541C86.4336 6.88498 87.6588 6.57154 89.226 6.57154Z" fill="currentColor" />
              <path d="M92.2564 0.787201H102.03C101.403 1.18612 101.09 1.95547 101.289 2.69632L106.817 22.4429L109.524 12.8118C109.609 12.4699 110.293 9.39248 110.265 7.91077C110.265 7.62583 110.236 7.25541 110.236 7.25541C110.094 4.94737 109.438 2.21192 107.472 0.787201H114.938C113.969 1.21461 113.228 2.06944 112.943 3.09524L107.501 22.5283C107.273 23.2692 107.615 24.0955 108.299 24.4945H98.5252C99.0665 24.181 99.4085 23.5826 99.4085 22.9558C99.4085 22.7848 99.4085 22.6423 99.3515 22.4714L93.8521 2.83879C93.6241 1.95547 93.0258 1.24311 92.2564 0.787201Z" fill="currentColor" />
              <path d="M114.156 24.4945C114.954 24.067 115.41 23.2692 115.41 22.3859V10.7317C115.41 9.42097 114.213 8.87958 114.213 8.87958H114.156C114.156 8.87958 119.256 8.19572 122.619 6.57154V22.4144C122.619 23.2692 123.075 24.067 123.844 24.4945H114.156ZM119 6.82799C117.319 6.82799 115.979 5.48876 115.979 3.8076C115.979 2.15493 117.319 0.787201 119 0.787201C120.653 0.787201 122.02 2.15493 122.02 3.8076C122.02 5.48876 120.653 6.82799 119 6.82799Z" fill="currentColor" />
              <path d="M140.735 6.57154C142.216 6.57154 143.299 7.14143 144.353 8.05325C146.262 9.70592 146.547 14.6639 142.473 14.6639H135.777H131.16C131.132 14.9489 131.103 15.2338 131.103 15.5188C131.103 20.1063 134.067 23.8106 136.489 23.8106H138.056C141.817 23.8106 143.897 19.508 144.638 17.4849V24.4945H132.87C127.912 24.4945 123.923 20.4768 123.923 15.5188C123.923 10.5892 127.912 6.57154 132.87 6.57154H140.735ZM139.025 10.8172C139.338 9.59194 139.139 8.33819 137.914 7.54035C137.401 7.19842 136.831 7.25541 136.432 7.25541C134.266 7.34089 131.787 10.2188 131.217 13.9801H134.694C136.688 13.9801 138.512 12.7263 139.025 10.8172Z" fill="currentColor" />
              <path d="M175.951 17.3709C176.805 14.8634 177.119 7.62583 174.868 6.57154H181.45C180.624 6.99896 179.968 7.73981 179.655 8.65163L174.241 24.4375L174.212 24.4945H173.5H166.604L164.04 17.3994L161.618 24.4375L161.589 24.4945H160.877H153.953L148.169 8.45217C147.884 7.65433 147.342 6.99896 146.601 6.57154H156.29C155.748 6.97046 155.52 7.68282 155.748 8.30969L161.248 23.4402L163.328 17.3709C163.413 17.0574 163.527 16.687 163.613 16.2596L160.792 8.45217C160.507 7.65433 159.965 6.99896 159.253 6.57154H162.245H168.827H168.913C168.371 6.97046 168.172 7.68282 168.4 8.30969L173.871 23.4402L175.951 17.3709Z" fill="currentColor" />
            </svg>
          </div>

          <!-- Display the error or success message -->
          <?php if (!empty($successMessage)) : ?>
            <p class="success-message text-center"><?php echo $successMessage; ?></p>

            <div class="text-center">
              <a href="login.php" class="btn btn-primary">Back to login</a>
            </div>
          <?php elseif (!empty($errorMessage)) : ?>
            <p class="error-message text-center"><?php echo $errorMessage; ?></p>
          <?php else : ?>
            <form action="forgotPassword.php" method="POST">
              <div class="form-group">
                <label for="usernameOrEmail">Username or Email</label>
                <input type="text" id="usernameOrEmail" name="usernameOrEmail" class="form-control mb-3" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Reset Password</button>
                <a href="login.php" class="btn btn-primary">Back to login</a>
              </div>
            </form>
          <?php endif; ?>


        </div>
      </div>
    </div>
  </div>
  <div class="jughead-footer mb-3">
    <p>Powered by <strong>Jughead Studios</strong></p>
    <p class="social-links mb-2">
      <a href="https://twitter.com/JUGZSOL" target="_blank"><i class="fa-brands fa-twitter"></i></a>
      <a href="https://github.com/JugheadStudio" target="_blank"><i class="fa-brands fa-github"></i></a>
      <a href="https://www.linkedin.com/in/ruanjordaan/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
      <a href="https://www.instagram.com/jugz.sol/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    </p>
  </div>
</body>

</html>