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
					<form id="search-form" method="get" action="<?php echo Yii::app()->createUrl('admin/loan/list', array('status'=>$status)); ?>">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<input type="text" class="form-control" name="search[name]" value="<?php if(!empty($_GET['search']['name'])) { echo $_GET['search']['name']; } ?>" placeholder="Name" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<input type="number" class="form-control" min=0 name="search[amount]" value="<?php if(!empty($_GET['search']['amount'])) { echo $_GET['search']['amount']; } ?>" placeholder="Amount" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<input type="number" class="form-control" name="search[interest_rate]" value="<?php if(!empty($_GET['search']['interest_rate'])) { echo $_GET['search']['interest_rate']; } ?>" placeholder="Interest Rate" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<input type="number" class="form-control" min=1 name="search[months_payable]" value="<?php if(!empty($_GET['search']['months_payable'])) { echo $_GET['search']['months_payable']; } ?>" placeholder="Months Payable" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<?php
										$this->widget('zii.widgets.jui.CJuiDatePicker',array(
										    'name'=>'search[date_created]',
										    // additional javascript options for the date picker plugin
										    'options'=>array(
										        'showAnim'=>'fold',
										        'dateFormat' => 'yy-mm-dd',
										    ),
										    'htmlOptions'=>array(
										        'class'=>'form-control',
										        'placeholder'=>'Date Posted',
										    ),
										));
									?>
								</div>
							</div>

							<br></br>
							<div class="col-md-3">
								<div class="form-group">
									<?php echo CHtml::link('Reset', array('loan/list', 'status'=>$status), array('class'=>'btn btn-danger btn-flat', 'title'=>'Reset Filters')); ?>
									<?php echo CHtml::link('Search', 'javascript:void(0);', array('class'=>'btn btn-success btn-flat', 'title'=>'Search', 'id'=>'btn-search')); ?>
								</div>
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
					'dataProvider'=>$loansDP,
					'itemView'=>'_view_loans',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>NAME <small>(SYSTEM ID)</small></th>
							<th>PACKAGE NAME</th>
							<th><small>AMOUNT</small> | <small>INTEREST RATE</small> | <small>MONTHS PAYABLE</small></th>
							<th>DATE POSTED</th>
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
	var date_created = "<?php echo !empty($_GET['search']['date_created']) ? $_GET['search']['date_created'] : ""; ?>"

	if (date_created != "") {
		$('#search_date_created').val(date_created);
	}

	$('#investment').addClass('active');
	$('.investment-'+class_name).addClass('active');

	$('#btn-search').click(function() {
		$('#search-form').submit();
	});
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