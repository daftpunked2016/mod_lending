<section class="content-header">
	<h1>
		Loans
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Loans', array('loan/index')); ?>
		</li>
		<li class="active"></li>
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
	<?php echo CHtml::link('<span class="fa fa-sign-in"></span> Post Loan Request', array('loan/postrequest'), array('class'=>'btn btn-danger btn-flat pull-right')); ?>
	<br></br>
	<div class="box box-solid">
		<div class="box-body">
			<div class="table-responsive">
				<?php  
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$loan_requestsDP,
						'itemView'=>'_view_loan_requests',
						'template' => "{sorter}
						<table id=\"example1\" class=\"table table-bordered table-hover\">
							<thead class='panel-heading'>
								<th>SYSTEM ID</th>
								<th>AMOUNT</th>
								<th>INTEREST RATE</th>
								<th>MONTHS PAYABLE</th>
								<th>STATUS</th>
								<th class='text-center'>Actions</th>
							</thead>
							<tbody>
								{items}
							</tbody>
						</table>
						{pager}",
						'emptyText' => "<tr><td class='text-center' colspan=\"5\">No available entries</td></tr>",
					));
				?>
			</div>
		</div>
	</div>
</section>

<!-- Large modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" id="modal-content">
    	<!-- start content here -->
    </div>
  </div>
</div>

<script type="text/javascript">
	$('#loans').addClass('active');

	$('.view-computation').click(function() {
		var url = $(this).data('url');

		$.ajax({
			url: url,
			beforeSend: function() {
				$("#modal-content").html("Loading...");
			},
			success: function(response) {
				$("#modal-content").html(response);
			}
		})
	});
</script>