<section class="content-header">
	<h1>
		Investments
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Investments', array('loan/investments')); ?>
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
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger collapsed-box">
				<div class="box-header with-border">
					<h4 class="box-title">
						Search Filters
					</h4>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="box-body" style="<?php if($search_filters != 0) { echo "display: block;"; } ?>">
					<form id="search-form" method="get" action="<?php echo Yii::app()->createUrl('loan/investments'); ?>">
						<div class="row">
							<div class="col-md-3">
								<input type="number" class="form-control" name="search[amount]" value="<?php if(!empty($_GET['search']['amount'])) { echo $_GET['search']['amount']; } ?>" placeholder="Amount" />
							</div>
							<div class="col-md-3">
								<input type="number" class="form-control" name="search[interest_rate]" value="<?php if(!empty($_GET['search']['interest_rate'])) { echo $_GET['search']['interest_rate']; } ?>" placeholder="Interest Rate" />
							</div>
							<div class="col-md-3">
								<input type="number" class="form-control" name="search[months_payable]" value="<?php if(!empty($_GET['search']['months_payable'])) { echo $_GET['search']['months_payable']; } ?>" placeholder="Months Payable" />
							</div>
							<div class="col-md-3">
								<?php echo CHtml::link('<span class="fa fa-refresh"></span> Reset', array('loan/investments'), array('class'=>'btn btn-danger btn-flat', 'title'=>'Reset Filters')); ?>
								<?php echo CHtml::link('<span class="fa fa-search"></span> Search', 'javascript:void(0);', array('class'=>'btn btn-success btn-flat', 'title'=>'Search', 'id'=>'btn-search')); ?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="box box-solid">
		<div class="box-body">
			<?php  
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$investmentsDP,
					'itemView'=>'_view_investments',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>SYSTEM ID</th>
							<th>PACKAGE NAME</th>
							<th>AMOUNT</th>
							<th>INTEREST RATE</th>
							<th>MONTHS PAYABLE</th>
							<th class='text-center' width='15%'>Actions</th>
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
$(function() {
	$('#investment').addClass('active');

	$('.apply-loan').click(function() {
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

	$('#btn-search').click(function() {
		$('#search-form').submit();
	});
});
</script>