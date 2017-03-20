<tr>
	<td><?php echo CHtml::encode($data->package_id); ?></td>
	<td><?php echo CHtml::encode($data->package->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($data->package->months_payable); ?> mos.</td>
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
					echo CHtml::link('Cancel', array('loan/cancel', 'id'=>$data->id), array('class'=>'btn-sm btn-warning', 'confirm'=>'Are you sure you want to cancel this application?'));
					break;
				case 'R':
					echo CHtml::link('Apply new loan', array('package/list'), array('class'=>'btn-sm btn-success'));
					break;
				default:
					# code...
					break;
			}
		?>
	</td>
</tr>