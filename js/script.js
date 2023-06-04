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
		var page = sessionStorage.getItem('activePage');
		var profilePicture = $('#profilePicture' + entryId).val();
		var name = $('#name' + entryId).val();
		var surname = $('#surname' + entryId).val();
		var dateOfBirth = $('#dateOfBirth' + entryId).val();
		var gender = $('#gender' + entryId).val();
		var phoneNumber = $('#phoneNumber' + entryId).val();
		var email = $('#email' + entryId).val();
		var address = $('#address' + entryId).val();
		var medicalAid = $('#medicalAid' + entryId).val();
		var medicalAidNumber = $('#medicalAidNumber' + entryId).val();
		var bloodType = $('#bloodType' + entryId).val();
		var allergy = $('#allergy' + entryId).val();
		var emergencyContactName = $('#emergencyContactName' + entryId).val();
		var emergencyContactNumber = $('#emergencyContactNumber' + entryId).val();

		// Determine the update PHP file based on the active page
		var updateUrl = '';
		if (page === 'patients') {
			updateUrl = 'updatePatients.php';
		} else if (page === 'doctors') {
			updateUrl = 'updateDoctors.php';
		}

		// Send an AJAX request to the respective update file
		$.ajax({
			url: updateUrl,
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
				address: address,
				medicalAid: medicalAid,
				medicalAidNumber: medicalAidNumber,
				bloodType: bloodType,
				allergy: allergy,
				emergencyContactName: emergencyContactName,
				emergencyContactNumber: emergencyContactNumber
			},
			error: function(xhr, status, error) {
				console.error(error); // Log the error to the console
				// Handle the error appropriately (e.g., show an error message to the user)
			}	
		});
	});
});

function loadContent(page) {
	// Remove single quotes from the page name
	page = page.replace(/'/g, '');

	// Store the active page in session storage
	sessionStorage.setItem('activePage', page);

	$.get('pages/' + page + '.php', function(response) {
		$('#content').html(response);
	});

	// Clear the active class from all nav links
	$('.nav-link').removeClass('active');

	// Add the active class to the current nav link
	$('#' + page + 'Link').addClass('active');
}

