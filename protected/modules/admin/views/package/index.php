<section class="content-header">
	<h1>
		Packages
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Packages', array('package/index')); ?>
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
	<!--  -->
	<?php if ($package_count < 3): ?>
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<?php echo CHtml::link('<i class="fa fa-plus"></i> Add Package', array('package/create'), array('class'=>'btn btn-info btn-flat pull-right', 'title'=>'Create Package')); ?>
			</div>
		</div>
		<br>
	<?php endif; ?>
	<div class="box box-solid">
		<div class="box-body">
			<?php
				$this->widget('zii.widgets.CListView', array(
  					'dataProvider'=>$packagesDP,
  					'itemView'=>'_view_packages',
  					'template' => "{sorter}
  					<table class='table table-hover table-striped'>
  						<thead class='panel-heading'>
  							<th>Package #</th>
  							<th>Amount</th>
  							<th>Interest</th>
  							<th>Months Payable</th>
  							<th class='text-center'>Actions</th>
  						</thead>
  						<tbody>
  							{items}
  						</tbody>
  					</table>
  					{pager}",
  					'emptyText' => "<tr><td class='text-center' colspan=\"5\">No data available</td></tr>",
  				));
			?>
		</div>
	</div>
</section>

<script type="text/javascript">
$(function() {
	$('#package').addClass('active');
});
</script>