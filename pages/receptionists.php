<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include '../db.php';
?>

<button class='btn btn-primary save-changes' data-bs-toggle='modal' data-bs-target='#addReceptionistModal'>Add Receptionist</button>

<table class='table'>
  <tr>
    <th></th>
    <th>ID</th>
    <th>Name</th>
    <th>Surname</th>
    <th>Actions</th>
  </tr>
  <?php
  // Select all records from the receptionist table
  $sql = "SELECT * FROM receptionist";
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
          <button class='btn btn-primary' data-entry-id='<?php echo $row['id']; ?>' data-bs-toggle='modal' data-bs-target='#viewEntry<?php echo $row['id']; ?>'>View</button>
        </td>
      </tr>
  <?php
    }
  } else {
    echo "No records found";
  }
  ?>
</table>

<?php
$results->data_seek(0); // Reset the result pointer
while ($row = $results->fetch_assoc()) {
?>
  <div class='modal fade' id='viewEntry<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='viewEntryLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='viewEntryLabel'>Edit Entry</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
          <form action="updateReceptionists.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class='row mb-3'>
              <div class="col text-center">
                <div class="position-relative modalPFP">
                  <img src="<?php echo $row['profilePicture']; ?>" alt="" width="150" height="150" class="rounded-circle me-2">
                  <label for="profilePicture<?php echo $row['id']; ?>" class="change-image-label">
                    <i class="fa fa-camera"></i>
                    <input class="form-control" type="file" id="profilePicture<?php echo $row['id']; ?>" name="profilePicture" accept="image/*">
                  </label>
                </div>
              </div>

              <div class="col">
                <label for='username<?php echo $row['id']; ?>' class='form-label'>User Name</label>
                <input type='text' class='form-control' id='username<?php echo $row['id']; ?>' name='username' value='<?php echo $row['username']; ?>'>

                <label for='rank<?php echo $row['id']; ?>' class='form-label'>Rank</label>
                <select class="form-select" id="rank<?php echo $row['id']; ?>" name="rank">
                  <option value="1" <?php if ($row['rank'] == '1') echo ' selected'; ?>>1</option>
                  <option value="2" <?php if ($row['rank'] == '2') echo ' selected'; ?>>2</option>
                </select>
              </div>

              <div class="col">
                <label for='password<?php echo $row['id']; ?>' class='form-label'>Password</label>
                <input type='password' class='form-control' id='password<?php echo $row['id']; ?>' name='password' value='<?php echo $row['password']; ?>'>
              </div>
            </div>

            <div class='row mb-3'>
              <div class="col">
                <label for='name<?php echo $row['id']; ?>' class='form-label'>Name</label>
                <input type='name' class='form-control' id='name<?php echo $row['id']; ?>' name='name' value='<?php echo $row['name']; ?>'>
              </div>

              <div class="col">
                <label for='surname<?php echo $row['id']; ?>' class='form-label'>Surname</label>
                <input type='text' class='form-control' id='surname<?php echo $row['id']; ?>' name='surname' value='<?php echo $row['surname']; ?>'>
              </div>
            </div>

            <div class='row mb-3'>
              <div class="col-6">
                <label for='dateOfBirth<?php echo $row['id']; ?>' class='form-label'>Date of Birth</label>
                <input type='date' class='form-control' id='dateOfBirth<?php echo $row['id']; ?>' name='dateOfBirth' value='<?php echo $row['dateOfBirth']; ?>'>
              </div>

              <div class="col-6">
                <label for="gender<?php echo $row['id']; ?>" class="form-label">Gender</label>
                <select class="form-select" id="gender<?php echo $row['id']; ?>" name="gender">
                  <option value="Male" <?php if ($row['gender'] == 'Male') echo ' selected'; ?>>Male</option>
                  <option value="Female" <?php if ($row['gender'] == 'Female') echo ' selected'; ?>>Female</option>
                  <option value="Other" <?php if ($row['gender'] == 'Other') echo ' selected'; ?>>Other</option>
                </select>
              </div>
            </div>

            <div class='row mb-3'>
              <div class="col-6">
                <label for='phoneNumber<?php echo $row['id']; ?>' class='form-label'>Contact Number</label>
                <input type='text' class='form-control' id='phoneNumber<?php echo $row['id']; ?>' name='phoneNumber' value='<?php echo $row['phoneNumber']; ?>'>
              </div>

              <div class="col-6">
                <label for='email<?php echo $row['id']; ?>' class='form-label'>Email</label>
                <input type='email' class='form-control' id='email<?php echo $row['id']; ?>' name='email' value='<?php echo $row['email']; ?>'>
              </div>
            </div>

            <div class="text-end">
              <?php if ($_SESSION['rank'] == 1) : ?>
                <button type="submit" class="btn btn-primary save-changes isEditing" data-entry-id="<?php echo $row['id']; ?>">Save changes</button>
                <a class="btn btn-danger isEditing" href="deleteDoctors.php?id=<?php echo $row['id']; ?>">Delete</a>
                <button type="button" class="btn btn-primary doctorCancelButton isEditing">Cancel</button>

                <button type="button" class="btn btn-primary doctorEditButton notEditing">Edit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <?php else : ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <?php endif; ?>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<!-- Add Doctor Modal -->
<div class='modal fade' id='addReceptionistModal' tabindex='-1' aria-labelledby='addReceptionistModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-lg'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='addReceptionistModalLabel'>Add Receptionist</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
        <form id='addPatientForm' action='createDoctors.php' method='POST' enctype="multipart/form-data">

          <div class='row mb-3'>
            <div class='col-6'>
              <label for='username' class='form-label'>User Name</label>
              <input type='text' class='form-control' id='username' name='username' required>
            </div>

            <div class="col-6">
              <label for='password' class='form-label'>Password</label>
              <input type='password' class='form-control' id='password' name='password' required>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col'>
              <label for='profilePicture' class='form-label'>Profile Picture</label>
              <input type='file' class='form-control' id='profilePicture' name='profilePicture' accept='image/*' required>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col-md-6'>
              <label for='name' class='form-label'>Name</label>
              <input type='text' class='form-control' id='name' name='name' required>
            </div>

            <div class='col-md-6'>
              <label for='surname' class='form-label'>Surname</label>
              <input type='text' class='form-control' id='surname' name='surname' required>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col-md-6'>
              <label for='dateOfBirth' class='form-label'>Date of Birth</label>
              <input type='date' class='form-control' id='dateOfBirth' name='dateOfBirth' required>
            </div>

            <div class='col-md-6'>
              <label for='gender' class='form-label'>Gender</label>
              <select class='form-select' id='gender' name='gender' required>
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
                <option value='Other'>Other</option>
              </select>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col-md-6'>
              <label for='phoneNumber' class='form-label'>Phone Number</label>
              <input type='text' class='form-control' id='phoneNumber' name='phoneNumber' required>
            </div>

            <div class='col-md-6'>
              <label for='email' class='form-label'>Email</label>
              <input type='email' class='form-control' id='email' name='email' required>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col-md-6'>
              <label for='roomID' class='form-label'>Room</label>
              <input type='text' class='form-control' id='roomID' name='roomID' required>
            </div>

            <div class='col-md-6'>
              <label for='discipline' class='form-label'>discipline</label>
              <input type='text' class='form-control' id='discipline' name='discipline' required>
            </div>
          </div>

          <div class='row mb-3'>
            <div class='col-md-6'>
              <label for='rate' class='form-label'>Rate</label>
              <input type='text' class='form-control' id='rate' name='rate' required>
            </div>
          </div>

          <button type='submit' class='btn btn-primary'>Save</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  if (typeof notEditingElements === 'undefined') {
    let notEditingElements = document.querySelectorAll('.notEditing');
    let isEditingElements = document.querySelectorAll('.isEditing');
    let doctorEditButtons = document.querySelectorAll('.doctorEditButton');
    let doctorCancelButtons = document.querySelectorAll('.doctorCancelButton');

    for (let i = 0; i < doctorEditButtons.length; i++) {
      doctorEditButtons[i].addEventListener('click', function() {
        hideElements(notEditingElements);
        showElements(isEditingElements);
      });
    }

    for (let i = 0; i < doctorCancelButtons.length; i++) {
      doctorCancelButtons[i].addEventListener('click', function() {
        showElements(notEditingElements);
        hideElements(isEditingElements);
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

    showElements(notEditingElements);
    hideElements(isEditingElements);
  }
</script>