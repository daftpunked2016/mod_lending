<tr>
	<td>Package <?php echo CHtml::encode($data->id); ?></td>
	<td><?php echo "P ".CHtml::encode(number_format($data->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($data->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($data->months_payable); ?> mos.</td>
	<td>

	</td>
</tr>