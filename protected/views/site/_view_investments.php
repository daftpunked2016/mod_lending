<?php $package = $data->package; ?>
<tr>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?> mos.</td>
	<td class="text-center">
		<?php echo CHtml::link('Apply Loan', 'javascript:void(0);', array('class'=>'btn-sm btn-primary apply-loan', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'data-url'=>Yii::app()->createUrl('loan/computation', array('id'=>$data->id)))); ?>
	</td>
</tr>