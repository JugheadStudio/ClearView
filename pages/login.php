<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';

session_start();

if (isset($_SESSION['username'])) {
    // User is logged in
    echo "Welcome, " . $_SESSION['username'] . "!";
} else {
    // User is not logged in
    echo "You are not logged in.";
}

// Check if the username and password values are set
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate the user's credentials
  $sql = "SELECT * FROM receptionist WHERE username = '$username' AND password = '$password'";
  $result = $conn->query($sql);

  if (!$result) {
    // Query execution failed, display the error message
    $error = "Query execution failed: " . $conn->error;
  } else {
    if ($result->num_rows == 1) {
      // Login successful, store user information in session
      $_SESSION['username'] = $username;
      // Redirect to the home page or any other authenticated content
      header("location: ../index.php");
      exit();
    } else {
      // Login failed, display an error message
      $error = "Invalid username or password";
    }
  }
} else {
  // Username or password not provided, display an error message
  $error = "Please provide both username and password";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ClearView - Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>

<body>

	<div class="container">
		<div class="login-form">
			<h2>Login</h2>
			<form action="login.php" method="POST">
				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" class="form-control" required>
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
				<p><?php echo isset($error) ? $error : ''; ?></p>
			</form>
		</div>
	</div>
</body>

</html>