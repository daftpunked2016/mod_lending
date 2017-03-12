<section class="content-header">
	<h1>
		<?php echo $page_header; ?>
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link($page_header, array('account/index', 'type'=>$type, 'status'=>$status)); ?>
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
	<!-- HIDDEN VALUES -->
	<input type="hidden" id="account_type" value="<?php echo $type; ?>">
	<input type="hidden" id="status" value="<?php echo $status; ?>">
	<?php
		if (!empty($search_array)) {
			foreach ($search_array as $key => $value) {
				echo "<input type='hidden' id='".$key."' value='".$value."' />";
			}
		}
	?>

	<!-- SEARCH FILTERS -->
	<div class="box-group" id="accordion">
        <div class="panel box box-danger">
	        <div class="box-header with-border">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed text-red">
					<span class="fa fa-search"></span>
					Search
				</a>
	            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed text-red">
					<span id="pull-down-filters" class="fa fa-angle-down text-red pull-right"></span>
				</a>
	        </div>
	        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
	            <div class="box-body">
	            	<form method="get" action="<?php echo Yii::app()->createUrl('admin/account/index', array('type'=>$type, 'status'=>$status)); ?>">
	            		<div class="form-group">
	            			<div class="row">
	            				<div class="col-md-3 col-sm-3">
	            					<label>System ID</label>
	            					<input type="text" id="id_name" name="search[system_id]" class="form-control" placeholder="System ID"/>
	            				</div>

	            				<?php if ($type == "B"): ?>
	            					<div class="col-md-3 col-sm-3">
		            					<label>Business Category</label>
		            					<select id="filter_bus_cat" name="search[business_category]" class="form-control">
					            			<option value="" disabled selected>Select Business Category</option>
					            			<?php foreach ($business_category as $value): ?>
					            				<option value="<?php echo $value->id; ?>"><?php echo $value->category; ?></option>
					            			<?php endforeach; ?>
					            		</select>
		            				</div>
		            				<div class="col-md-3 col-sm-3">
		            					<label>Business Type</label>
		            					<select id="filter_bus_type" name="search[business_type]" class="form-control">
					            			<option value="" disabled selected>Select Business Category First</option>
					            		</select>
		            				</div>
	            				<?php endif; ?>

	            				<div class="col-md-3 col-sm-3">
	            					<label>Name</label>
	            					<input id="filter_name" type="text" class="form-control" name="search[name]" placeholder="Name" />
	            				</div>
	            				<div class="col-md-12">
	            					<br>
	            				</div>
	            				<div class="col-md-12">
	            					<div class="pull-right">
	            						<?php echo CHtml::link('Reset', array('account/index', 'type'=>$type, 'status'=>$status), array('title'=>'Reset Filters', 'class'=>'btn btn-success btn-flat')); ?>
	            						<button class="btn btn-danger btn-flat" title="Search">
		            						Search
		            					</button>
	            					</div>
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
			<?php if ($type == "B"): ?>
				<?php  
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$accountsDP,
						'itemView'=>'_view_accounts',
						'template' => "{sorter}
						<table id=\"example1\" class=\"table table-bordered table-hover\">
							<thead class='panel-heading'>
								<th>Type of Business</th>
								<th>Name</th>
								<th>Contact Number</th>
								<th>System ID</th>
								<th>Status</th>
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
			<?php else: ?>
				<?php  
					$this->widget('zii.widgets.CListView', array(
						'dataProvider'=>$accountsDP,
						'itemView'=>'_view_accounts',
						'template' => "{sorter}
						<table id=\"example1\" class=\"table table-bordered table-hover\">
							<thead class='panel-heading'>
								<th>Name</th>
								<th>Contact Number</th>
								<th>System ID</th>
								<th>Status</th>
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
			<?php endif; ?>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		var	account_type = $('#account_type').val();
		var	status = $('#status').val();

		// search filters start
		var business_category = $('#business_category').val();
		var business_type = $('#business_type').val();
		var name = $('#name').val();
		var id_name = $('#system_id').val();

		if (business_category != null || business_type != null || name != null || id_name != null) {
			$('#pull-down-filters').trigger('click');
		}

		if (name) {
			$('#filter_name').val(name);
		}

		if (id_name) {
			$('#id_name').val(id_name);
		}

		if (business_category) {
			$('#filter_bus_cat').val(business_category);

			$.ajax({
				url: "<?php echo Yii::app()->createUrl('common/listbusinesstype'); ?>",
				data: {cat_id : business_category},
				method: "POST",
				success: function(response) {
					$('#filter_bus_type').html(response);
					$('#filter_bus_type').val(business_type);
				}
			});
		}
		// search filters end

		if (account_type == "I") {
			$('#investor_tab_left_side').addClass('active');

			if (status === "P") {
				$('#investor_tab_left_side > ul > li.pending-accounts').addClass('active');
			} else if (status === "A") {
				$('#investor_tab_left_side > ul > li.approved-accounts').addClass('active');
			} else if (status === "D") {
				$('#investor_tab_left_side > ul > li.disabled-accounts').addClass('active');
			} else {
				$('#investor_tab_left_side > ul > li.rejected-accounts').addClass('active');
			}

		} else {
			$('#borrower_tab_left_side').addClass('active');

			if (status === "P") {
				$('#borrower_tab_left_side > ul > li.pending-accounts').addClass('active');
			} else if (status === "A") {
				$('#borrower_tab_left_side > ul > li.approved-accounts').addClass('active');
			} else if (status === "D") {
				$('#borrower_tab_left_side > ul > li.disabled-accounts').addClass('active');
			} else {
				$('#borrower_tab_left_side > ul > li.rejected-accounts').addClass('active');
			}
		}


		$(document).on('change', '#filter_bus_cat', function() {
			var cat_id = $(this).val();

			$.ajax({
				url: "<?php echo Yii::app()->createUrl('common/listbusinesstype'); ?>",
				data: {cat_id : cat_id},
				method: "POST",
				success: function(response) {
					$('#filter_bus_type').html(response);
				}
			});
		});
	});
</script>