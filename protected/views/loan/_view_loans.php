<tr>
	<td><?php echo CHtml::encode($data->package_id); ?></td>
	<td><?php echo CHtml::encode($data->package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($data->package->months_payable); ?> months</td>
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
					echo CHtml::link('Cancel', array('loan/cancel', 'id'=>$data->id), array('class'=>'btn-sm btn-warning cancel-investment', 'confirm'=>'Are you sure you want to cancel this application?'));
					break;
				case 'R':
					echo CHtml::link('Post new Investment', array('package/list'), array('class'=>'btn-sm btn-success'));
					break;
				default:
					# code...
					break;
			}
		?>
	</td>
</tr>