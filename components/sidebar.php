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

		<hr>

		<img src="https://avatars.githubusercontent.com/u/55399963?v=4" alt="" width="50" height="50" class="rounded-circle me-2">
		<button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#signOutModal">Sign out</button>
	</div>
</div>
