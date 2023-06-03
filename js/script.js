$(document).ready(function() {
	// Get the stored active page
	var activePage = sessionStorage.getItem('activePage');

	if (activePage) {
			loadContent(activePage);
	} else {
			// Load initial content
			loadContent('patients');
	}

	// Handle sidebar navigation
	$('.nav-link').click(function(e) {
		e.preventDefault();
		var page = $(this).attr('id').replace('Link', '');
		loadContent(page);
	});
	
	$(document).on('click', '.save-changes', function() {
		var entryId = $(this).data('entry-id');
		var profilePicture = $('#profilePicture' + entryId).val();
		var name = $('#name' + entryId).val();
		var surname = $('#surname' + entryId).val();
		var dateOfBirth = $('#dateOfBirth' + entryId).val();
		var gender = $('#gender' + entryId).val();
		var phoneNumber = $('#phoneNumber' + entryId).val();
		var email = $('#email' + entryId).val();
		var medicalAid = $('#medicalAid' + entryId).val();
		var medicalAidNumber = $('#medicalAidNumber' + entryId).val();
		var bloodType = $('#bloodType' + entryId).val();
		var allergy = $('#allergy' + entryId).val();
		var emergencyContactName = $('#emergencyContactName' + entryId).val();
		var emergencyContactNumber = $('#emergencyContactNumber' + entryId).val();

		// Send an AJAX request to updatePatients.php
		$.ajax({
			url: 'updatePatients.php',
			method: 'POST',
			data: {
				id: entryId,
				profilePicture: profilePicture,
				name: name,
				surname: surname,
				dateOfBirth: dateOfBirth,
				gender: gender,
				phoneNumber: phoneNumber,
				email: email,
				medicalAid: medicalAid,
				medicalAidNumber: medicalAidNumber,
				bloodType: bloodType,
				allergy: allergy,
				emergencyContactName: emergencyContactName,
				emergencyContactNumber: emergencyContactNumber
			}
		});
	});
});

function loadContent(page) {
	// Remove single quotes from the page name
	page = page.replace(/'/g, '');

	// Store the active page in session storage
	sessionStorage.setItem('activePage', page);

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
					document.getElementById('content').innerHTML = this.responseText;
			}
	};
	xhttp.open('GET', 'pages/' + page + '.php', true);
	xhttp.send();

	// Clear the active class from all nav links
	var navLinks = document.querySelectorAll('.nav-link');
	navLinks.forEach(function(link) {
			link.classList.remove('active');
	});

	// Add the active class to the current nav link
	var currentLink = document.getElementById(page + 'Link');
	currentLink.classList.add('active');
}
