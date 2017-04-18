<section class="content-header">
	<h1>
		Investments
		<small><?php echo $class_name; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Investments', array('loan/list')); ?>
		</li>
		<li class="active"><?php echo ucfirst($class_name); ?></li>
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
					'dataProvider'=>$loansDP,
					'itemView'=>'_view_loans',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>SYSTEM ID</th>
							<th>PACKAGE NAME</th>
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
					'emptyText' => "<tr><td class='text-center' colspan=\"7\">No available entries</td></tr>",
				));
			?>
		</div>
	</div>
</section>

<!-- Large modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="modal-content">
    	<!-- start content here -->
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
	var class_name = "<?php echo $class_name; ?>";

	$('#investment').addClass('active');
	$('.investment-'+class_name).addClass('active');
});

$(document).on('click', '.view-account', function() {
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