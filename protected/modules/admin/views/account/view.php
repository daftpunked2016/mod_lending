<div class="modal-header label-danger">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="gridSystemModalLabel">
		SYSTEM ID # <b><?php echo $user->id_name; ?></b>
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-4">
			<label>Email:</label> <?php echo $account->username; ?>
			<br>
			<?php 
				switch ($account->status) {
					case 'A':
						$account_status = "<span class='label label-success'>Approved</span>";
						break;
					case 'D':
						$account_status = "<span class='label label-danger'>Disabled</span>";
						break;
					case 'P':
						$account_status = "<span class='label label-warning'>Pending</span>";
						break;
					default:
						$account_status = "<span class='label label-danger'>Rejected</span>";
						break;
				}
			?>
			<label>Account Status:</label> <?php echo $account_status; ?>
			<?php if ($account->account_type == "I"): ?>
				<br>
				<label>Check Payable to:</label> <?php echo $user->check_payable_to; ?>
			<?php endif ?>
		</div>
		<div class="col-md-4">
			<label>First name:</label> <?php echo $user->first_name; ?>
			<br>
			<?php if ($user->middle_name): ?>
				<label>Middle name:</label> <?php echo $user->middle_name; ?>
				<br>
			<?php endif; ?>
			<label>Last name:</label> <?php echo $user->last_name; ?>
			<br>
			<label>Contact #:</label> <?php echo $user->contact_number; ?>
			<br>
			<label>TIN #:</label> <?php echo $user->tin; ?>
		</div>
		<div class="col-md-4">
			<label>Address 1:</label> <?php echo $user->address1; ?>
			<br>
			<?php if ($user->address2): ?>
				<label>Address 2:</label> <?php echo $user->address2; ?>
				<br>
			<?php endif; ?>
			<label>Province:</label> <?php echo $province->name; ?>
			<br>
			<label>City:</label> <?php echo $city->name; ?>
		</div>
	</div>
	<div class="row">
		<?php
			$count = 1;
			foreach ($supporting_documents as $key => $value):
		?>
			<div class="col-md-12">
				<label>Supporting Documents #<?php echo $count++; ?></label>:
				<?php if ($account->account_type == "B"): ?>
					<?php if ($user->dti_file_id == $value->id): ?>
					<label>(DTI)</label>
					<?php elseif($user->sec_file_id == $value->id): ?>	
					<label>(SEC)</label>
					<?php endif; ?>
				<?php endif; ?>
				<br>
				<img class="img-responsive pad" src="<?php echo $value->file_path; ?>" style="padding: 0;">
				<br>
			</div>
		<?php endforeach; ?>
	</div>
</div>