<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';
?>

<button class='btn btn-primary save-changes' data-bs-toggle='modal' data-bs-target='#addPatientModal'>Add Patient</button>

<table class='table'>
	<tr>
		<th></th>
		<th>ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Actions</th>
	</tr>
	<?php
	// Select all records from the patients table
	$sql = "SELECT * FROM patients";
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
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='viewEntryLabel'>Edit Entry</h5>
					<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
				</div>
				<div class='modal-body'>
					<form action="updatePatients.php" method="POST" enctype="multipart/form-data">
						<div class='mb-3'>
							<label for='profilePicture<?php echo $row['id']; ?>' class='form-label'>Profile Picture</label>
							<input type='text' class='form-control' id='profilePicture<?php echo $row['id']; ?>' value='<?php echo $row['profilePicture']; ?>'>
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
								<label for='medicalAid<?php echo $row['id']; ?>' class='form-label'>Medical Aid</label>
								<input type='text' class='form-control' id='medicalAid<?php echo $row['id']; ?>' name='medicalAid' value='<?php echo $row['medicalAid']; ?>'>
							</div>

							<div class="col-6">
								<label for='medicalAidNumber<?php echo $row['id']; ?>' class='form-label'>Medical Aid Number</label>
								<input type='text' class='form-control' id='medicalAidNumber<?php echo $row['id']; ?>' name='medicalAidNumber' value='<?php echo $row['medicalAidNumber']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for="bloodType<?php echo $row['id']; ?>" class="form-label">Blood Type</label>
								<select class="form-select" id="bloodType<?php echo $row['id']; ?>" name="bloodType">
									<option value="Not Sure" <?php if ($row['bloodType'] == 'Not Sure') echo 'selected'; ?>>Not Sure</option>
									<option value="A" <?php if ($row['bloodType'] == 'A') echo 'selected'; ?>>A</option>
									<option value="B" <?php if ($row['bloodType'] == 'B') echo 'selected'; ?>>B</option>
									<option value="AB" <?php if ($row['bloodType'] == 'AB') echo 'selected'; ?>>AB</option>
									<option value="O" <?php if ($row['bloodType'] == 'O') echo 'selected'; ?>>O</option>
								</select>
							</div>

							<div class="col-6">
								<label for='allergy<?php echo $row['id']; ?>' class='form-label'>Allergies</label>
								<input type='text' class='form-control' id='allergy<?php echo $row['id']; ?>' name='allergy' value='<?php echo $row['allergy']; ?>'>
							</div>
						</div>

						<div class='row mb-3'>
							<div class="col-6">
								<label for='emergencyContactName<?php echo $row['id']; ?>' class='form-label'>Emergency Contact</label>
								<input type='text' class='form-control' id='emergencyContactName<?php echo $row['id']; ?>' name='emergencyContactName' value='<?php echo $row['emergencyContactName']; ?>'>
							</div>

							<div class="col-6">
								<label for='emergencyContactNumber<?php echo $row['id']; ?>' class='form-label'>Emergency Contact Number</label>
								<input type='text' class='form-control' id='emergencyContactNumber<?php echo $row['id']; ?>' name='emergencyContactNumber' value='<?php echo $row['emergencyContactNumber']; ?>'>
							</div>
						</div>

						<div class='mb-3'>
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

<!-- Add Patient Modal -->
<div class='modal fade' id='addPatientModal' tabindex='-1' aria-labelledby='addPatientModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='addPatientModalLabel'>Add Patient</h5>
				<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>
				<form id='addPatientForm' action='createPatients.php' method='POST' enctype="multipart/form-data">
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
							<label for='address' class='form-label'>Address</label>
							<input type='text' class='form-control' id='address' name='address' required>
						</div>
						<div class='col-md-6'>
							<label for='medicalAid' class='form-label'>Medical Aid</label>
							<input type='text' class='form-control' id='medicalAid' name='medicalAid' required>
						</div>
					</div>
					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='medicalAidNumber' class='form-label'>Medical Aid Number</label>
							<input type='text' class='form-control' id='medicalAidNumber' name='medicalAidNumber' required>
						</div>
						<div class='col-md-6'>
							<label for='bloodType' class='form-label'>Blood Type</label>
							<select class='form-select' id='bloodType' name='bloodType' required>
								<option value='Not Sure' selected>Not Sure</option>
								<option value='A'>A</option>
								<option value='B'>B</option>
								<option value='AB'>AB</option>
								<option value='O'>O</option>
							</select>
						</div>
					</div>
					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='allergy' class='form-label'>Allergy</label>
							<input type='text' class='form-control' id='allergy' name='allergy' required>
						</div>
						<div class='col-md-6'>
							<label for='emergencyContactName' class='form-label'>Emergency Contact Name</label>
							<input type='text' class='form-control' id='emergencyContactName' name='emergencyContactName' required>
						</div>
					</div>
					<div class='row mb-3'>
						<div class='col-md-6'>
							<label for='emergencyContactNumber' class='form-label'>Emergency Contact Number</label>
							<input type='text' class='form-control' id='emergencyContactNumber' name='emergencyContactNumber' required>
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
<script src='script.js'></script>