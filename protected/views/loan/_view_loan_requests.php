<?php
	$package = $data->loan->package;
	$investor_data = $data->loan->account;
?>

<tr>
	<td><?php echo CHtml::encode($investor_data->user->id_name); ?></td>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?>%</td>
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
			if ($data->status == "P") {
				echo CHtml::link('Cancel', array('loan/cancelloan', 'id'=>$data->id), array('class'=>'btn-sm btn-warning', 'title'=>'Cancel Loan Request', 'confirm'=>'Are you sure you want to Cancel your Loan Request?'));
			}
		?>

		<?php echo CHtml::link('View Computation', 'javascript:void(0);', array('class'=>'btn-sm btn-primary view-computation', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'title'=>'Apply for Loan', 'data-url'=>Yii::app()->createUrl('loan/computation', array('id'=>$data->loan_id, 'viewing'=>true)))); ?>
	</td>
</tr>