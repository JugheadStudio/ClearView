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

	// Handle save changes button click
	$(document).on('click', '.save-changes', function() {
			var entryId = $(this).data('entry-id');
			var name = $('#name' + entryId).val();
			var surname = $('#surname' + entryId).val();

			// Send AJAX request to update patient data
			$.ajax({
					url: 'updatePatients.php',
					method: 'POST',
					data: {
							id: entryId,
							name: name,
							surname: surname
					},
					success: function(response) {
							console.log(response);
							// Update the table row with the new data
							$('#row-' + entryId + ' td:nth-child(3)').text(name);
							$('#row-' + entryId + ' td:nth-child(4)').text(surname);

							// Close the modal
							$('#viewEntry' + entryId).modal('hide');
					},
					error: function(xhr, status, error) {
							console.log(xhr.responseText);
							// Handle error case here
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
