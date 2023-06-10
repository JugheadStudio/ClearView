<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// User is not logged in
if (!isset($_SESSION['username'])) {
	// Redirect to the login page
	header("location: pages/login.php");
	exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ClearView - Home</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="css/styles.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-1 p-0">
				<?php include 'components/sidebar.php'; ?>
			</div>

			<div class="col-11" id="content">

			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/sidebar.js"></script>
</body>

</html>