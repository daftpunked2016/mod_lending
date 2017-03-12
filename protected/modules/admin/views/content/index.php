<section class="content-header">
	<h1>
		Content Management
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::encode('Content Management', array('content/index')); ?>
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
		<div class="box-header">
			<span class="fa fa-cogs"></span> List of Contents
			<?php echo CHtml::link('<i class="fa fa-plus"></i> Add Content', array('content/add'), array('class'=>'btn btn-info btn-flat pull-right', 'title'=>'Add new Content')); ?>
		</div>
		<div class="box-body">
			<?php  
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$contentDP,
					'itemView'=>'_view_content',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>ID #</th>
							<th>Description</th>
							<th>Status</th>
							<th>Actions</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td class='text-center' colspan=\"4\">No available entries</td></tr>",
				));
			?>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('#content_management').addClass('active');
	});
</script>