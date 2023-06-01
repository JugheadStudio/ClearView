<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db.php';
?>

<table class='table'>
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Actions</th>
    </tr>
    <?php
    // Select all records from the patients table
    $sql = "SELECT * FROM patients";
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
                    <button class='btn btn-primary save-changes' data-entry-id='<?php echo $row['id']; ?>' data-bs-toggle='modal' data-bs-target='#viewEntry<?php echo $row['id']; ?>'>View</button>
                </td>
            </tr>
            <div class='modal fade' id='viewEntry<?php echo $row['id']; ?>' tabindex='-1' aria-labelledby='viewEntryLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='viewEntryLabel'>Edit Entry</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <form>
                                <div class='mb-3'>
                                    <label for='name<?php echo $row['id']; ?>' class='form-label'>Name</label>
                                    <input type='text' class='form-control' id='name<?php echo $row['id']; ?>' value='<?php echo $row['name']; ?>'>
                                </div>
                                <div class='mb-3'>
                                    <label for='surname<?php echo $row['id']; ?>' class='form-label'>Surname</label>
                                    <input type='text' class='form-control' id='surname<?php echo $row['id']; ?>' value='<?php echo $row['surname']; ?>'>
                                </div>
                                <button type='button' class='btn btn-primary save-changes' data-entry-id='<?php echo $row['id']; ?>'>Save changes</button>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No records found";
    }

    // Close the database connection
    $conn->close();
    ?>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
