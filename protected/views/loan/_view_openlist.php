<?php $package = $data->package; ?>

<tr>
	<td><b><?php echo CHtml::encode($data->account->user->id_name); ?></b></td>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?> month/s</td>
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
		<?php echo CHtml::link('Push Invite to Invest', array('loan/invite', 'id'=>$data->id), array('class'=>'btn-sm btn-primary btn-invite')); ?>
	</td>
</tr>