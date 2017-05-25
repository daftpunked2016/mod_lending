<div class="modal-header label-danger">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="gridSystemModalLabel">
		<strong>Loan Summary</strong>
	</h4>
</div>
<div class="modal-body">
	<table class="table table-bordered table-hover">
		<tr>
			<td>Amount</td>
			<td><?php echo $result['amount']; ?></td>
		</tr>
		<tr>
			<td>Monthly Interest Rate</td>
			<td><?php echo $result['interest_rate']; ?>%</td>
		</tr>
		<tr>
			<td>Terms (months)</td>
			<td><?php echo $result['months_payable']; ?></td>
		</tr>
		<tr>
			<td>Monthly Amortization</td>
			<td><?php echo $result['monthly_amortization']; ?></td>
		</tr>
		<tr>
			<td>Total Payment</td>
			<td><?php echo $result['total_payment']; ?></td>
		</tr>
		<tr>
			<td>One time Service Fee</td>
			<td><?php echo $result['one_time_service_fee']; ?></td>
		</tr>
		<tr>
			<td class="pull-right"><b>Grand Total</b> :</td>
			<td><b><?php echo $result['grand_total']; ?></b></td>
		</tr>
	</table>
</div>
<?php if ($viewing == false): ?>
	<div class="modal-footer">
		<div class="pull-left">
			<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
		</div>
		<div class="pull-right">
			<?php echo CHtml::link('Apply', array('loan/apply', 'loan_id'=>$loan_data->id), array('class'=>'btn btn-danger btn-flat btn-apply', 'title'=>'Apply Loan')); ?>
		</div>
	</div>
<?php endif ?>

<script type="text/javascript">
$(function() {
	$('.btn-apply').click(function() {
		$(this).removeClass('btn-danger').addClass('btn-warning disabled').html('Processing');
	});
})
</script>