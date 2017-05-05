<?php $package = $data->package; ?>

<tr>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?> month/s</td>
	<td>
		<?php
			if ($data->loan_id) {
				echo CHtml::link('View Invitation', "javascript:void(0);", array('class'=>'btn-sm btn-primary'));
			} else {
				echo "<span class='label label-warning'> <span class='fa fa-refresh fa-spin'></span> Waiting for Invite </span>";
			}
		?>
	</td>
	<td>
		<?php
			switch ($data->status) {
				case 'A':
					echo "<label class='label label-success'>Approved</label>";
					break;
				case 'P':
					echo "<label class='label label-warning'>Pending</label>";
					break;
				default:
					echo "<label class='label label-danger'>Rejected</label>";
					break;
			}
		?>
	</td>
	<td>
		<?php
			switch ($data->status) {
				case 'P':
					echo CHtml::link('Cancel', array('loan/cancelrequest', 'id'=>$data->id), array('class'=>'btn-sm btn-warning', 'confirm'=>'Are you sure you want to Cancel your Post Loan Request?'));
					break;
				
				default:
					# code...
					break;
			}
		?>
	</td>
</tr>