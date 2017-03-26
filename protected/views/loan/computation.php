<div class="modal-header label-danger">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="gridSystemModalLabel">
		<strong>Loan Summary</strong>
	</h4>
</div>
<div class="modal-body">
	<table class="table table-bordered table-hover">
		<tr>
			<td>Package Name</td>
			<td><?php echo $result['package_name']; ?></td>
		</tr>
		<tr>
			<td>Amount</td>
			<td><?php echo $result['amount']; ?></td>
		</tr>
		<tr>
			<td>Rate</td>
			<td><?php echo $result['rate']; ?></td>
		</tr>
		<tr>
			<td>Payable in</td>
			<td><?php echo $result['payable_in']; ?> months</td>
		</tr>
		<tr>
			<td>Service Fee</td>
			<td><?php echo $result['service_fee']; ?></td>
		</tr>
		<tr>
			<td><b>Total:</b></td>
			<td><b><?php echo $result['total']; ?></b></td>
		</tr>
		<tr>
			<td colspan="2">
				<br>
			</td>
		</tr>
		<tr>
			<td>Issue < <b><?php echo $result['payable_in']; ?></b> > checks</td>
			<td><?php echo $result['per_month_total']; ?> (monthly)</td>
		</tr>
		<tr>
			<td>Payable to</td>
			<td>
				<strong><?php echo $result['payable_to']; ?></strong>
			</td>
		</tr>
	</table>
</div>
<div class="modal-footer">
	<div class="pull-left">
		<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
	</div>
	<div class="pull-right">
		<?php echo CHtml::link('Apply', array('loan/apply', 'loan_id'=>$loan_data->id), array('class'=>'btn btn-danger btn-flat', 'title'=>'Apply Loan')); ?>
	</div>
</div>