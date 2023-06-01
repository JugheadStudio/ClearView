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