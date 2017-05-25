<div class="modal-header label-danger">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="gridSystemModalLabel">
		<strong>Loan Amortization Schedule</strong>
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-6">
			<table class="table table-bordered table-hover">
				<thead class="bg-gray">
					<th colspan="2">Loan Summary</th>
				</thead>
				<tr>
					<td>Amount</td>
					<td>₱ <?php echo number_format($loan->package->amount, 2); ?></td>
				</tr>
				<tr>
					<td>Monthly Interest Rate</td>
					<td><?php echo $loan_schedule['loan_summary']['interest_rate']; ?>%</td>
				</tr>
				<tr>
					<td>Terms (months)</td>
					<td><?php echo $loan_schedule['loan_summary']['months_payable']; ?></td>
				</tr>
				<tr>
					<td>Monthly Amortization</td>
					<td>₱ <?php echo $loan_schedule['loan_summary']['monthly_amortization']; ?></td>
				</tr>
				<tr>
					<td>Total Interest</td>
					<td>₱ <?php echo $loan_schedule['loan_summary']['total_interest']; ?></td>
				</tr>
				<tr>
					<td>Total Payment</td>
					<td>₱ <?php echo $loan_schedule['loan_summary']['total_payment']; ?></td>
				</tr>
				<tr>
					<td>One time Service Fee</td>
					<td>₱ <?php echo $loan_schedule['loan_summary']['one_time_service_fee']; ?></td>
				</tr>
				<tr>
					<td class="pull-right"><b>Grand Total</b> :</td>
					<td><b>₱ <?php echo $loan_schedule['loan_summary']['grand_total']; ?></b></td>
				</tr>
			</table>
		</div>
		<div class="col-md-6"></div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead class="bg-gray">
				<th width="5%">Pmnt No.</th>
				<th>Payment Date</th>
				<th>Loan Balance</th>
				<th>Schedule Payment</th>
				<th>Principal</th>
				<th>Interest</th>
				<th>Ending Balance</th>
				<th>Cumulative Interest</th>
				<th width="5%" class="text-center">Action</th>
			</thead>

			<?php foreach ($loan_schedule['schedule'] as $key => $value): ?>
				<tr>
					<td><?php echo $key; ?></td>
					<td><?php echo date('M. d, Y', strtotime($value['payment_date'])); ?></td>
					<td>₱ <?php echo $value['loan_balance']; ?></td>
					<td>₱ <?php echo $value['scheduled_payment']; ?></td>
					<td>₱ <?php echo $value['principal']; ?></td>
					<td>₱ <?php echo $value['interest']; ?></td>
					<td>₱ <?php echo $value['ending_balance']; ?></td>
					<td>₱ <?php echo $value['cumulative_interest']; ?></td>
					<td class="text-center">
						<?php
							$bool = 0;
							
							if ($checks) {
								foreach ($checks as $key2 => $val) {
									if ($val->check_dated == date('Y-m-d', strtotime($value['payment_date']))) {
										echo CHtml::link('<span class="fa fa-trash"></span>', 'javascript:void(0);', array('class'=>'btn btn-danger delete-check', 'title'=>'Delete Check', 'data-url'=>Yii::app()->createUrl('admin/request/deletecheck', array('id'=>$val->id)), 'data-date'=>$value['payment_date']));
										$bool++;
									}
								}
							}

							if (!$bool) {
								echo CHtml::link('<span class="fa fa-check"></span>', 'javascript:void(0);', array('class'=>'btn btn-success add-check', 'title'=>'Add Check', 'data-url'=>Yii::app()->createUrl('admin/request/addcheck', array('id'=>$request->id)), 'data-date'=>$value['payment_date']));
							}
						?>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>
<div class="modal-footer">
	<div class="pull-left">
		<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
	</div>
</div>