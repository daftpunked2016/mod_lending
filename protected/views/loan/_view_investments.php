<tr>
	<td><?php echo CHtml::encode($data->account->user->id_name); ?></td>
	<td><?php echo CHtml::encode($data->package_id); ?></td>
	<td>P <?php echo CHtml::encode(number_format($data->package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($data->package->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($data->package->months_payable); ?> mos.</td>
	<td class="text-center">
		<?php echo CHtml::link('Apply for Loan', 'javascript:void(0);', array('class'=>'btn-sm btn-primary apply-loan', 'title'=>'Apply for Loan')); ?>
	</td>
</tr>