<section class="content-header">
	<h1>
		Loan Requests
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Loan Requests', array('loan/openlist')); ?>
		</li>
		<li class="active">List</li>
	</ol>
	<br>
	<?php 
		foreach(Yii::app()->user->getFlashes() as $key=>$message) {
			if($key === 'success') {
				echo '<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Success!</h4>
				    '.$message.'</div>';
			} else {
				echo '<div class="alert alert-danger alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-ban"></i> Error!</h4>
				    '.$message.'</div>';
			}
		}
	?>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-body">
			<?php  
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$requestsDP,
					'itemView'=>'_view_openlist',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>SYSTEM ID</th>
							<th>AMOUNT</th>
							<th>INTEREST RATE</th>
							<th>MONTHS PAYABLE</th>
							<th>STATUS</th>
							<th class='text-center' width='15%'>Actions</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td class='text-center' colspan=\"6\">No available entries</td></tr>",
				));
			?>
		</div>
	</div>
</section>

<script type="text/javascript">
$(function() {
	$('#open_request').addClass('active');

	$('.btn-invite').click(function() {

		if (confirm('Are you sure you want to Push an Invite to this Request?')) {
			$(this).removeClass('btn-primary').addClass('btn-warning disabled').html('Processing');
		} else {
			return false;
		}
	});
});
</script>