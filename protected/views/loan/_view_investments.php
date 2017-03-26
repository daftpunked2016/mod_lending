<tr>
	<td><?php echo CHtml::encode($data->account->user->id_name); ?></td>
	<td><?php echo CHtml::encode(strtoupper($data->package->package_name)); ?></td>
	<td>P <?php echo CHtml::encode(number_format($data->package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($data->package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($data->package->months_payable); ?> months</td>
	<td class="text-center">
		<?php echo CHtml::link('Apply Loan', 'javascript:void(0);', array('class'=>'btn-sm btn-primary apply-loan', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'title'=>'Apply for Loan', 'data-url'=>Yii::app()->createUrl('loan/computation', array('id'=>$data->id)))); ?>
	</td>
</tr>