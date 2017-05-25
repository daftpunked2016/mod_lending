<?php $package = $data->package; ?>

<tr>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?> mos.</td>
	<td>
		<?php
			if ($data->loan_id) {
				echo "<span class='label label-success'>Invited</span>";
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
	<td class="text-center">
		<?php
			switch ($data->status) {
				case 'P':
					echo CHtml::link('Cancel', array('loan/cancelrequest', 'id'=>$data->id), array('class'=>'btn-sm btn-warning', 'confirm'=>'Are you sure you want to Cancel your Post Loan Request?'));
					break;
				default:

					break;
			}
		?>

		<?php
			if (!empty($data->loan_id)) {
				echo CHtml::link('View Computation', 'javascript:void(0);', array('class'=>'btn-sm btn-primary view-computation', 'data-toggle'=>'modal', 'data-target'=>'.computation', 'title'=>'Apply for Loan', 'data-url'=>Yii::app()->createUrl('loan/computation', array('id'=>$data->loan_id, 'viewing'=>true))));
			}
		?>
	</td>
</tr>