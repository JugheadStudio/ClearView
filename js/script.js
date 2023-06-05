$(document).ready(function() {
	// Get the stored active page
	let activePage = sessionStorage.getItem('activePage');

	if (activePage) {
			loadContent(activePage);
	} else {
			// Load initial content
			loadContent('appointments');
	}

	// Handle sidebar navigation
	$('.nav-link').click(function(e) {
			e.preventDefault();
			let page = $(this).attr('id').replace('Link', '');
			loadContent(page);
	});

	$(document).on('click', '.save-changes', function() {
		let entryId = $(this).data('entry-id');
		let page = sessionStorage.getItem('activePage');
		let profilePicture = $('#profilePicture' + entryId).val();
		let name = $('#name' + entryId).val();
		let surname = $('#surname' + entryId).val();
		let dateOfBirth = $('#dateOfBirth' + entryId).val();
		let gender = $('#gender' + entryId).val();
		let phoneNumber = $('#phoneNumber' + entryId).val();
		let email = $('#email' + entryId).val();
		let address = $('#address' + entryId).val();
		let medicalAid = $('#medicalAid' + entryId).val();
		let medicalAidNumber = $('#medicalAidNumber' + entryId).val();
		let bloodType = $('#bloodType' + entryId).val();
		let allergy = $('#allergy' + entryId).val();
		let emergencyContactName = $('#emergencyContactName' + entryId).val();
		let emergencyContactNumber = $('#emergencyContactNumber' + entryId).val();

		// Determine the update PHP file based on the active page
		let updateUrl = '';
		if (page === 'patients') {
			updateUrl = 'updatePatients.php';
		} else if (page === 'doctors') {
			updateUrl = 'updateDoctors.php';
		} else if (page === 'receptionist') {
			updateUrl = 'updateReceptionist.php';
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

		// Get the user's profile picture URL from the data attribute
    let profilePictureUrl = $('.logged-in-user-profile-picture').data('profile-picture');

    // Update the image source with the profile picture URL
    $('.logged-in-user-profile-picture').attr('src', profilePictureUrl);
	});

	// Get the user's profile picture URL from the data attribute
	let profilePictureUrl = $('.logged-in-user-profile-picture').data('profile-picture');

	// Update the image source with the profile picture URL
	$('.logged-in-user-profile-picture').attr('src', profilePictureUrl);

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
