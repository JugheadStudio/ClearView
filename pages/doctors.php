<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';
?>

<button class='btn btn-primary save-changes' data-bs-toggle='modal' data-bs-target='#addPatientModal'>Add Doctor</button>

<table class='table'>
	<tr>
		<th></th>
		<th>ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Actions</th>
	</tr>
	<?php
	// Select all records from the doctor table
	$sql = "SELECT * FROM doctor";
	$results = $conn->query($sql);

	// Check if there are any records
	if ($results->num_rows > 0) {
		while ($row = $results->fetch_assoc()) {
	?>
			<tr id="row-<?php echo $row['id']; ?>">
				<td><img src='<?php echo $row['profilePicture']; ?>' alt='' width='50' height='50' class='rounded-circle me-2'></td>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['surname']; ?></td>
				<td>
					<button class='btn btn-primary' data-entry-id='<?php echo $row['id']; ?>' data-bs-toggle='modal' data-bs-target='#viewEntry<?php echo $row['id']; ?>'>View</button>
				</td>
			</tr>
	<?php
		}
	} else {
		echo "No records found";
	}
	?>
</table>

<?php
$results->data_seek(0); // Reset the result pointer
while ($row = $results->fetch_assoc()) {
?>
	<div class='modal fade' id='viewEntry<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='viewEntryLabel' aria-hidden='true'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='viewEntryLabel'>Edit Entry</h5>
					<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
				</div>
				<div class='modal-body'>
					<form action="updateDoctors.php" method="POST" enctype="multipart/form-data">
    				<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
						<div class='mb-3'>
							<label for='profilePicture<?php echo $row['id']; ?>' class='form-label'>Profile Picture</label>
							<input type='text' class='form-control' id='profilePicture<?php echo $row['id']; ?>' name='profilePicture' value='<?php echo $row['profilePicture']; ?>'>
						</div>

						<div class='row mb-3'>
							<div class='col-6'>
								<label for='username<?php echo $row['id']; ?>' class='form-label'>User Name</label>
								<input type='text' class='form-control' id='username<?php echo $row['id']; ?>' name='username' value='<?php echo $row['username']; ?>'>
							</div>

							<div class="col-6">
								<label for='password<?php echo $row['id']; ?>' class='form-label'>Password</label>
								<input type='password' class='form-control' id='password<?php echo $row['id']; ?>' name='password' value='<?php echo $row['password']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='name<?php echo $row['id']; ?>' class='form-label'>Name</label>
								<input type='text' class='form-control' id='name<?php echo $row['id']; ?>' name='name' value='<?php echo $row['name']; ?>'>
							</div>

							<div class="col-6">
								<label for='surname<?php echo $row['id']; ?>' class='form-label'>Surname</label>
								<input type='text' class='form-control' id='surname<?php echo $row['id']; ?>' name='surname' value='<?php echo $row['surname']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='dateOfBirth<?php echo $row['id']; ?>' class='form-label'>Date of Birth</label>
								<input type='date' class='form-control' id='dateOfBirth<?php echo $row['id']; ?>' name='dateOfBirth' value='<?php echo $row['dateOfBirth']; ?>'>
							</div>

							<div class="col-6">
								<label for="gender<?php echo $row['id']; ?>" class="form-label">Gender</label>
								<select class="form-select" id="gender<?php echo $row['id']; ?>" name="gender">
									<option value="Male" <?php if ($row['gender'] == 'Male') echo ' selected'; ?>>Male</option>
									<option value="Female" <?php if ($row['gender'] == 'Female') echo ' selected'; ?>>Female</option>
									<option value="Other" <?php if ($row['gender'] == 'Other') echo ' selected'; ?>>Other</option>
								</select>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='phoneNumber<?php echo $row['id']; ?>' class='form-label'>Contact Number</label>
								<input type='text' class='form-control' id='phoneNumber<?php echo $row['id']; ?>' name='phoneNumber' value='<?php echo $row['phoneNumber']; ?>'>
							</div>

							<div class="col-6">
								<label for='email<?php echo $row['id']; ?>' class='form-label'>Email</label>
								<input type='email' class='form-control' id='email<?php echo $row['id']; ?>' name='email' value='<?php echo $row['email']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='roomID<?php echo $row['id']; ?>' class='form-label'>Room</label>
								<input type='text' class='form-control' id='roomID<?php echo $row['id']; ?>' name='roomID' value='<?php echo $row['roomID']; ?>'>
							</div>

							<div class="col-6">
								<label for='discipline<?php echo $row['id']; ?>' class='form-label'>Discipline</label>
								<input type='text' class='form-control' id='discipline<?php echo $row['id']; ?>' name='discipline' value='<?php echo $row['discipline']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='rate<?php echo $row['id']; ?>' class='form-label'>Rate</label>
								<input type='text' class='form-control' id='rate<?php echo $row['id']; ?>' name='rate' value='<?php echo $row['rate']; ?>'>
							</div>
						</div>

						<button type='submit' class='btn btn-primary save-changes' data-entry-id='<?php echo $row['id']; ?>'>Save changes</button>
					</form>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>

<!-- Add Doctor Modal -->
<div class='modal fade' id='addPatientModal' tabindex='-1' aria-labelledby='addPatientModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='addPatientModalLabel'>Add Doctor</h5>
				<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>
				<form id='addPatientForm' action='createDoctors.php' method='POST' enctype="multipart/form-data">

					<div class='row mb-3'>
						<div class='col-6'>
							<label for='username' class='form-label'>User Name</label>
							<input type='text' class='form-control' id='username' name='username' required>
						</div>

						<div class="col-6">
							<label for='password' class='form-label'>Password</label>
							<input type='password' class='form-control' id='password' name='password' required>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col'>
							<label for='profilePicture' class='form-label'>Profile Picture</label>
							<input type='file' class='form-control' id='profilePicture' name='profilePicture' accept='image/*' required>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='name' class='form-label'>Name</label>
							<input type='text' class='form-control' id='name' name='name' required>
						</div>

						<div class='col-md-6'>
							<label for='surname' class='form-label'>Surname</label>
							<input type='text' class='form-control' id='surname' name='surname' required>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='dateOfBirth' class='form-label'>Date of Birth</label>
							<input type='date' class='form-control' id='dateOfBirth' name='dateOfBirth' required>
						</div>

						<div class='col-md-6'>
							<label for='gender' class='form-label'>Gender</label>
							<select class='form-select' id='gender' name='gender' required>
								<option value='Male'>Male</option>
								<option value='Female'>Female</option>
								<option value='Other'>Other</option>
							</select>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='phoneNumber' class='form-label'>Phone Number</label>
							<input type='text' class='form-control' id='phoneNumber' name='phoneNumber' required>
						</div>

						<div class='col-md-6'>
							<label for='email' class='form-label'>Email</label>
							<input type='email' class='form-control' id='email' name='email' required>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='roomID' class='form-label'>Room</label>
							<input type='text' class='form-control' id='roomID' name='roomID' required>
						</div>

						<div class='col-md-6'>
							<label for='discipline' class='form-label'>discipline</label>
							<input type='text' class='form-control' id='discipline' name='discipline' required>
						</div>
					</div>

					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='rate' class='form-label'>Rate</label>
							<input type='text' class='form-control' id='rate' name='rate' required>
						</div>
					</div>

					<button type='submit' class='btn btn-primary'>Save</button>

				</form>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
			</div>
		</div>
	</div>
</div>

<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>