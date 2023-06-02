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
					<button class='btn btn-primary save-changes' data-entry-id='<?php echo $row['id']; ?>' data-bs-toggle='modal' data-bs-target='#viewEntry<?php echo $row['id']; ?>'>View</button>
				</td>
			</tr>
			<div class='modal fade' id='viewEntry<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='viewEntryLabel' aria-hidden='true'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title' id='viewEntryLabel'>Edit Entry</h5>
							<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
						</div>
						<div class='modal-body'>
							<form>
								<div class='mb-3'>
									<label for='profilePicture<?php echo $row['id']; ?>' class='form-label'>Profile Picture</label>
									<input type='text' class='form-control' id='profilePicture<?php echo $row['id']; ?>' value='<?php echo $row['profilePicture']; ?>'>
								</div>
								<div class='mb-3'>
									<label for='name<?php echo $row['id']; ?>' class='form-label'>Name</label>
									<input type='text' class='form-control' id='name<?php echo $row['id']; ?>' value='<?php echo $row['name']; ?>'>
								</div>
								<div class='mb-3'>
									<label for='surname<?php echo $row['id']; ?>' class='form-label'>Surname</label>
									<input type='text' class='form-control' id='surname<?php echo $row['id']; ?>' value='<?php echo $row['surname']; ?>'>
								</div>
								<button type='button' class='btn btn-primary save-changes' data-entry-id='<?php echo $row['id']; ?>'>Save changes</button>
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
	} else {
		echo "No records found";
	}

	// Close the database connection
	$conn->close();
	?>
</table>

<!-- Add Patient Modal -->
<div class='modal fade' id='addPatientModal' tabindex='-1' aria-labelledby='addPatientModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='addPatientModalLabel'>Add Patient</h5>
				<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>
				<form id='addPatientForm' action='createPatients.php' method='POST'>
					<div class='mb-3'>
						<label for='id' class='form-label'>ID</label>
						<input type='text' class='form-control' id='id' name='id' required>
					</div>
					<div class='mb-3'>
						<label for='profilePicture' class='form-label'>Profile Picture</label>
						<input type='text' class='form-control' id='profilePicture' name='profilePicture' required>
					</div>
					<div class='mb-3'>
						<label for='name' class='form-label'>Name</label>
						<input type='text' class='form-control' id='name' name='name' required>
					</div>
					<div class='mb-3'>
						<label for='surname' class='form-label'>Surname</label>
						<input type='text' class='form-control' id='surname' name='surname' required>
					</div>
					<div class='mb-3'>
						<label for='dateOfBirth' class='form-label'>Date of Birth</label>
						<input type='date' class='form-control' id='dateOfBirth' name='dateOfBirth' required>
					</div>
					<div class='mb-3'>
						<label for='gender' class='form-label'>Gender</label>
						<select class='form-select' id='gender' name='gender' required>
							<option value='Male'>Male</option>
							<option value='Female'>Female</option>
							<option value='Other'>Other</option>
						</select>
					</div>
					<div class='mb-3'>
						<label for='phoneNumber' class='form-label'>Phone Number</label>
						<input type='text' class='form-control' id='phoneNumber' name='phoneNumber' required>
					</div>
					<div class='mb-3'>
						<label for='email' class='form-label'>Email</label>
						<input type='email' class='form-control' id='email' name='email' required>
					</div>
					<div class='mb-3'>
						<label for='address' class='form-label'>Address</label>
						<input type='text' class='form-control' id='address' name='address' required>
					</div>
					<div class='mb-3'>
						<label for='medicalAid' class='form-label'>Medical Aid</label>
						<input type='text' class='form-control' id='medicalAid' name='medicalAid' required>
					</div>
					<div class='mb-3'>
						<label for='medicalAidNumber' class='form-label'>Medical Aid Number</label>
						<input type='text' class='form-control' id='medicalAidNumber' name='medicalAidNumber' required>
					</div>
					<div class='mb-3'>
						<label for='bloodType' class='form-label'>Blood Type</label>
						<input type='text' class='form-control' id='bloodType' name='bloodType' required>
					</div>
					<div class='mb-3'>
						<label for='allergy' class='form-label'>Allergy</label>
						<input type='text' class='form-control' id='allergy' name='allergy' required>
					</div>
					<div class='mb-3'>
						<label for='emergencyContactName' class='form-label'>Emergency Contact Name</label>
						<input type='text' class='form-control' id='emergencyContactName' name='emergencyContactName' required>
					</div>
					<div class='mb-3'>
						<label for='emergencyContactNumber' class='form-label'>Emergency Contact Number</label>
						<input type='text' class='form-control' id='emergencyContactNumber' name='emergencyContactNumber' required>
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