<?php

$loggedInUser = null; // Initialize the variable

// Check if the user is logged in and the session variables exist
if (isset($_SESSION['username']) && isset($_SESSION['profilePicture'])) {
  $loggedInUser = $_SESSION['username'];
  $profilePicture = $_SESSION['profilePicture'];
  $name = $_SESSION['name'];
}

?>

<div class="d-flex flex-nowrap sidebar-wrapper">
	<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark sidebar-container">
		<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
			<span class="fs-4">ClearView</span>
		</a>

		<hr>

		<ul class="nav nav-pills flex-column mb-auto">
			<li class="nav-item">
				<a id="appointmentsLink" class="nav-link" onclick="loadContent('appointments')">
					Appointments
				</a>
			</li>
			<?php if ($_SESSION['rank'] == 1) : ?>
			<li>
				<a id="receptionistsLink" class="nav-link" onclick="loadContent('receptionists')">
					Receptionists
				</a>
			</li>
			<?php endif; ?>
			<li>
				<a id="doctorsLink" class="nav-link" onclick="loadContent('doctors')">
					Doctors
				</a>
			</li>
			<li>
				<a id="patientsLink" class="nav-link" onclick="loadContent('patients')">
					Patients
				</a>
			</li>
		</ul>

		<div class="row">
			<div class="col text-center">
				<img src="<?php echo $profilePicture; ?>" alt="Profile Picture" width="65" height="65" class="rounded-circle logged-in-user-profile-picture mb-4" >
				<p><?php echo $name; ?></p>
				<button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#signOutModal">Sign out</button>
			</div>

		</div>

		<!-- Sign Out Modal -->
		<div class="modal fade" id="signOutModal" tabindex="-1" aria-labelledby="signOutModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="signOutModalLabel">Sign Out Confirmation</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body text-dark">
						<p>Are you sure you want to sign out?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<a href="pages/logout.php" class="btn btn-primary">Sign Out</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>