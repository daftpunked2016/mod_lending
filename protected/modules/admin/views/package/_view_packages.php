<tr>
	<td><?php echo CHtml::encode(strtoupper($data->package_name)); ?></td>
	<td><?php echo "P ".CHtml::encode(number_format($data->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($data->interest_rate); ?></td>
	<td><?php echo CHtml::encode($data->months_payable); ?> mos.</td>
	<td class="text-center">
		<?php echo CHtml::link('<i class="fa fa-edit"></i> Edit', array('package/edit', 'id'=>$data->id), array('class'=>'btn-sm btn-success', 'title'=>'Edit Package')); ?>
	</td>
</tr>