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
				<img src="https://avatars.githubusercontent.com/u/55399963?v=4" alt="" width="65" height="65" class="rounded-circle mb-4">
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