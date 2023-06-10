<div class="row pt-5">
  <div class="col"></div>

  <div class="col d-flex justify-content-center">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="daily-tab" data-bs-toggle="pill" data-bs-target="#daily" type="button" role="tab" aria-controls="daily" aria-selected="true">Daily</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="weekly-tab" data-bs-toggle="pill" data-bs-target="#weekly" type="button" role="tab" aria-controls="weekly" aria-selected="false">Weekly</button>
      </li>
    </ul>
  </div>

  <div class="col">
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
        Add Appointment
      </button>
    </div>
  </div>
</div>

<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAppointmentModalLabel">Add Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="createAppointment.php" method="POST">
          <div class="row">
            <div class="col mb-3">
              <label for="patientID" class="form-label">Patient ID</label>
              <input type="text" class="form-control typeahead" id="patientID" name="patientID" required>
              <div id="patientResults"></div>
            </div>

            <div class="col mb-3">
              <label for="doctorID" class="form-label">Doctor ID</label>
              <input type="text" class="form-control typeahead" id="doctorID" name="doctorID" required>
              <div id="doctorResults"></div>
            </div>
          </div>

          <div class="row">
            <div class="col mb-3">
              <label for="roomID" class="form-label">Room</label>
              <input type="text" class="form-control" id="roomID" name="roomID" required>
            </div>
          </div>

          <div class="row">
            <div class="col mb-3">
              <label for="date" class="form-label">Date</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="col mb-3">
              <label for="time" class="form-label">Time</label>
              <select class="form-select" id="time" name="time" required>
                <option value="" selected disabled>Select a time</option>
                <?php
                // Generate time options from 00:30 to 23:30
                $time = strtotime('00:00');
                while ($time <= strtotime('23:30')) {
                  $formattedTime = date('H:i A', $time);
                  echo "<option value=\"$formattedTime\">$formattedTime</option>";
                  $time += 1800; // Add 30 minutes (in seconds)
                }
                ?>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab" tabindex="0">

    <h1>Daily Calendar</h1>
    <div class="row">
      <div class="col">
        <h2>Monday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 1</li>
          <li class="list-group-item">Appointment 2</li>
          <li class="list-group-item">Appointment 3</li>
        </ul>
      </div>
    </div>

  </div>

  <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab" tabindex="0">

    <h1>Weekly Calendar</h1>
    <div class="row">
      <div class="col">
        <h2>Monday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 1</li>
          <li class="list-group-item">Appointment 2</li>
        </ul>
      </div>
      <div class="col">
        <h2>Tuesday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 3</li>
        </ul>
      </div>
      <!-- Repeat the columns for the remaining days of the week -->
      <div class="col">
        <h2>Wednesday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 4</li>
        </ul>
      </div>
      <div class="col">
        <h2>Thursday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 5</li>
        </ul>
      </div>
      <div class="col">
        <h2>Friday</h2>
        <ul class="list-group">
          <li class="list-group-item">Appointment 6</li>
          <li class="list-group-item">Appointment 7</li>
        </ul>
      </div>
    </div>

  </div>
</div>

<script>
  $(document).ready(function() {
    // Patient ID Typeahead
    $('#patientID').on('input', function() {
      let query = $(this).val();

      $.ajax({
        url: 'search.php',
        method: 'POST',
        data: {
          query: query,
          type: 'patient'
        },
        dataType: 'json',
        success: function(data) {
          let resultsContainer = $('#patientResults');
          resultsContainer.empty();

          if (data.length > 0) {
            data.forEach(function(patient) {
              let result = $('<div>').text(patient.name);
              resultsContainer.append(result);
            });
          } else {
            let result = $('<div>').text('No matching patients found');
            resultsContainer.append(result);
          }
        }
      });
    });

    // Doctor ID Typeahead
    $('#doctorID').on('input', function() {
      let query = $(this).val();

      $.ajax({
        url: 'search.php',
        method: 'POST',
        data: {
          query: query,
          type: 'doctor'
        },
        dataType: 'json',
        success: function(data) {
          let resultsContainer = $('#doctorResults');
          resultsContainer.empty();

          if (data.length > 0) {
            data.forEach(function(doctor) {
              let result = $('<div>').text(doctor.name);
              resultsContainer.append(result);
            });
          } else {
            let result = $('<div>').text('No matching doctors found');
            resultsContainer.append(result);
          }
        }
      });
    });

    // Add event listener to search results
    $(document).on('click', '.search-result', function() {
      var name = $(this).text(); // Get the clicked result's name
      $('#search-input').val(name); // Populate the input field with the name
    });

    // Perform search on keyup event in the search input
    $('#search-input').keyup(function() {
      var query = $(this).val(); // Get the search query from the input field
      var type = $('#search-type').val(); // Get the search type (patient or doctor)

      // Perform an AJAX request to the search.php file
      $.ajax({
        url: 'search.php',
        type: 'POST',
        dataType: 'json',
        data: {
          query: query,
          type: type
        },
        success: function(response) {
          var resultsContainer = $('#search-results');
          resultsContainer.empty(); // Clear previous results

          // Loop through the response and append each result to the container
          $.each(response, function(index, result) {
            var resultItem = $('<div class="search-result"></div>').text(result.name);
            resultsContainer.append(resultItem);
          });
        }
      });
    });
  });
</script>