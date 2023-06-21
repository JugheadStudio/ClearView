<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include '../db.php';

// Function to retrieve patient details
function getPatientDetails($conn, $patientID)
{
  $patientQuery = "SELECT * FROM patients WHERE id = $patientID";
  $patientResult = $conn->query($patientQuery);
  return $patientResult->fetch_assoc();
}

// Function to retrieve doctor details
function getDoctorDetails($conn, $doctorID)
{
  $doctorQuery = "SELECT * FROM doctor WHERE id = $doctorID";
  $doctorResult = $conn->query($doctorQuery);
  return $doctorResult->fetch_assoc();
}

// Function to retrieve room details
function getRoomDetails($conn, $roomID)
{
  $roomQuery = "SELECT * FROM room WHERE id = $roomID";
  $roomResult = $conn->query($roomQuery);
  return $roomResult->fetch_assoc();
}

// Function to generate time options
function generateTimeOptions($selectedTime)
{
  $timeOptions = '';
  $time = strtotime('00:00');
  while ($time <= strtotime('23:30')) {
    $formattedTime = date('H:i A', $time);
    $selected = ($formattedTime === $selectedTime) ? 'selected' : '';
    $timeOptions .= "<option value='$formattedTime' $selected>$formattedTime</option>";
    $time += 1800; // Add 30 minutes (in seconds)
  }
  return $timeOptions;
}
?>

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
              <label for="patientID" class="form-label">Patient</label>
              <select class="form-control m-2" name="patientID">
                <option value="all">All</option>
                <?php
                // Select all records from the patients and order them alphabetically
                $sql = "SELECT * FROM patients ORDER BY name ASC";
                $results = $conn->query($sql);

                // Iterate through each row of the results and create an option for each name
                while ($row = $results->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' . $row['name'] . ' ' . $row['surname'] . '</option>';
                }

                ?>
              </select>
            </div>

            <div class="col mb-3">
              <label for="doctorID" class="form-label">Doctor</label>
              <select class="form-control m-2" name="doctorID">
                <option value="all">All</option>
                <?php
                // Select all records from the doctor and order them alphabetically
                $sql = "SELECT * FROM doctor ORDER BY name ASC";
                $results = $conn->query($sql);

                // Iterate through each row of the results and create an option for each name
                while ($row = $results->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' . $row['name'] . ' ' . $row['surname'] . '</option>';
                }

                ?>

              </select>
            </div>
          </div>

          <div class="row">
            <div class="col mb-3">
              <label for="roomID" class="form-label">Room</label>
              <select class="form-control m-2" name="roomID">
                <option value="all">All</option>
                <?php
                // Select all records from the room and order them alphabetically
                $sql = "SELECT * FROM room ORDER BY name ASC";
                $results = $conn->query($sql);

                // Iterate through each row of the results and create an option for each room
                while ($row = $results->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' . $row['name'] . ' ' . $row['Building'] . '</option>';
                }

                // Close the database connection
                $conn->close();
                ?>
              </select>
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

<hr>

<div class="tab-content container-fluid" id="pills-tabContent">

  <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab" tabindex="0">
    <div class="row justify-content-center">
      <div class="col-4">
        <div class="input-group mb-3">
          <input type="date" class="form-control" placeholder="Date" aria-label="Date" aria-describedby="basic-addon2">
          <span class="input-group-text" id="basic-addon2">Search</span>
        </div>
      </div>
    </div>

    <div id="daily-appointmens" class="row">
      <?php
      // Include the database connection file
      include '../db.php';

      // Select all records from the appointment table
      $sql = "SELECT * FROM appointment";
      $results = $conn->query($sql);

      // Check if there are any records
      if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
          // Get the patient details
          $patient = getPatientDetails($conn, $row['patientID']);

          // Get the doctor details
          $doctor = getDoctorDetails($conn, $row['doctorID']);

          // Get the room details
          $room = getRoomDetails($conn, $row['roomID']);
      ?>
          <div class="col-3 appointment-card mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $patient['name'] . ' ' . $patient['surname']; ?></h5>
                <h6 class="card-subtitle text-muted"><?php echo $doctor['name'] . ' ' . $doctor['surname']; ?></h6>
                <p class="card-text"><?php echo $room['name'] ?></p>
                <p class="card-text"><?php echo $row['date']; ?></p>
                <p class="card-text"><?php echo $row['time']; ?></p>

                <button class='btn btn-primary' data-entry-id='<?php echo $row['id']; ?>' data-bs-toggle='modal' data-bs-target='#viewEntry<?php echo $row['id']; ?>'>View</button>
                <a class="btn btn-danger" href="deleteAppointment.php?id=<?php echo $row['id']; ?>">Delete</a>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        echo "No records found";
      }
      ?>
    </div>

    <!-- Update appointment modal -->
    <?php
    $results->data_seek(0); // Reset the result pointer
    while ($row = $results->fetch_assoc()) {
    ?>
      <div class='modal fade' id='viewEntry<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='viewEntryLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='viewEntryLabel'>Edit Appointment</h5>
              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
              <form action="updateAppointment.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <div class='row mb-3'>
                  <div class="col-6">
                    <label for='patientID<?php echo $row['id']; ?>' class='form-label'>Patient Name</label>
                    <select class='form-control isEditing' id='patientID<?php echo $row['id']; ?>' name='patientID'>
                      <?php
                      // Select all records from the room table and order them alphabetically
                      $sql = "SELECT * FROM patients ORDER BY name ASC";
                      $patientResults = $conn->query($sql);

                      // Check if there are any rows returned from the query
                      if ($patientResults && $patientResults->num_rows > 0) {
                        while ($patient = $patientResults->fetch_assoc()) {
                          // Create an option for each patient
                          $selected = ($row['patientID'] == $patient['id']) ? 'selected' : '';
                          echo "<option value='" . $patient['id'] . "' " . $selected . ">" . $patient['name'] . " " . $patient['surname'] . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-6">
                    <label for='doctorID<?php echo $row['id']; ?>' class='form-label'>Doctor Name</label>
                    <select class='form-control isEditing' id='doctorID<?php echo $row['id']; ?>' name='doctorID'>
                      <?php
                      // Select all records from the room table and order them alphabetically
                      $sql = "SELECT * FROM doctor ORDER BY name ASC";
                      $doctorResults = $conn->query($sql);

                      // Check if there are any rows returned from the query
                      if ($doctorResults && $doctorResults->num_rows > 0) {
                        while ($doctor = $doctorResults->fetch_assoc()) {
                          // Create an option for each doctor
                          $selected = ($row['doctorID'] == $doctor['id']) ? 'selected' : '';
                          echo "<option value='" . $doctor['id'] . "' " . $selected . ">" . $doctor['name'] . " " . $doctor['surname'] . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class='row mb-3'>
                  <div class="col-6">
                    <label for='roomID<?php echo $row['id']; ?>' class='form-label'>Room</label>
                    <select class='form-control isEditing' id='roomID<?php echo $row['id']; ?>' name='roomID'>
                      <?php
                      // Select all records from the room table and order them alphabetically
                      $sql = "SELECT * FROM room ORDER BY name ASC";
                      $roomResults = $conn->query($sql);

                      // Check if there are any rows returned from the query
                      if ($roomResults && $roomResults->num_rows > 0) {
                        while ($room = $roomResults->fetch_assoc()) {
                          // Create an option for each room
                          $selected = ($row['roomID'] == $room['id']) ? 'selected' : '';
                          echo "<option value='" . $room['id'] . "' " . $selected . ">" . $room['name'] . " " . $room['Building'] . "</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-6">
                    <label for="date<?php echo $row['id']; ?>" class="form-label">Date</label>
                    <input type='date' class='form-control isEditing' id='date<?php echo $row['id']; ?>' name='date' value='<?php echo $row['date']; ?>'>
                  </div>

                  <div class="col-6">
                    <label for="time<?php echo $row['id']; ?>" class="form-label">Time</label>
                    <select class="form-select isEditing" id="time<?php echo $row['id']; ?>" name="time" required>
                      <option value="" selected disabled>Select a time</option>
                      <?php echo generateTimeOptions($row['time']); ?>
                    </select>
                  </div>
                </div>

                <div class="text-end">
                  <button type="submit" class="btn btn-primary save-changes isEditingButton" data-entry-id="<?php echo $row['id']; ?>">Save changes</button>
                  <a class="btn btn-danger isEditingButton" href="deleteAppointment.php?id=<?php echo $row['id']; ?>">Delete</a>
                  <button type="button" class="btn btn-primary appointmentCancelButton isEditingButton">Cancel</button>

                  <button type="button" class="btn btn-primary appointmentEditButton notEditing">Edit</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    ?>


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
    if (typeof notEditingElements === 'undefined') {
      let notEditingElements = document.querySelectorAll('.notEditing');
      let isEditingElements = document.querySelectorAll('.isEditing');
      let isEditingButtons = document.querySelectorAll('.isEditingButton');
      let appointmentEditButtons = document.querySelectorAll('.appointmentEditButton');
      let appointmentCancelButtons = document.querySelectorAll('.appointmentCancelButton');

      for (let i = 0; i < appointmentEditButtons.length; i++) {
        appointmentEditButtons[i].addEventListener('click', function() {
          hideElements(notEditingElements);
          showElements(isEditingButtons);
          enableFields(isEditingElements);
        });
      }

      for (let i = 0; i < appointmentCancelButtons.length; i++) {
        appointmentCancelButtons[i].addEventListener('click', function() {
          showElements(notEditingElements);
          hideElements(isEditingButtons);
          disableFields(isEditingElements);
        });
      }

      function hideElements(elements) {
        for (let i = 0; i < elements.length; i++) {
          elements[i].style.display = 'none';
        }
      }

      function showElements(elements) {
        for (let i = 0; i < elements.length; i++) {
          elements[i].style.display = '';
        }
      }

      function enableFields(elements) {
        for (let i = 0; i < elements.length; i++) {
          elements[i].disabled = false;
        }
      }

      function disableFields(elements) {
        for (let i = 0; i < elements.length; i++) {
          elements[i].disabled = true;
        }
      }

      showElements(notEditingElements);
      hideElements(isEditingButtons);
      disableFields(isEditingElements);
    }
  </script>