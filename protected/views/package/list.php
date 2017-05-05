<section class="content-header">
	<h1>
		Packages
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Packages', array('package/list')); ?>
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
					<form id="search-form" method="get" action="<?php echo Yii::app()->createUrl('package/list'); ?>">
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
								<?php echo CHtml::link('<span class="fa fa-search"></span>', 'javascript:void(0);', array('class'=>'btn btn-primary btn-flat', 'title'=>'Search', 'id'=>'btn-search')); ?>
								<?php echo CHtml::link('<span class="fa fa-refresh"></span>', array('package/list'), array('class'=>'btn btn-danger btn-flat', 'title'=>'Reset Filters')); ?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<?php if (!empty($packages)): ?>
			<?php foreach ($packages as $val): ?>
				<div class="col-md-4 col-xs-12 col-sm-6">
					<!-- Widget: user widget style 1 -->
					<div class="box box-widget widget-user">
						<!-- Add the bg color to the header using any of the bg-* classes -->
						<div class="widget-user-header <?php //echo $val->class; ?>bg-red disabled color-palette">
							<h3 class="widget-user-username"><strong>P <?php echo number_format($val->amount, 2); ?></strong></h3>
							<h5 class="widget-user-desc"><?php echo strtoupper($val->package_name); ?> PACKAGE</h5>
						</div>
						<!-- <div class="widget-user-image"> -->
							<!-- <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Avatar"> -->
						<!-- </div> -->
						<div class="box-footer">
							<div class="row">
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header">
											<?php echo $val->interest_rate * 100; ?>
											<small>%</small>
										</h5>
										<small class="description-text">INTEREST</small>
									</div>
								</div>
								<div class="col-sm-4 border-right">
									<div class="description-block">
										<h5 class="description-header"><?php echo $val->months_payable; ?></h5>
										<small class="description-text">MONTHS PAYABLE</small>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="description-block">
										<?php echo CHtml::link('<h5><i class="fa fa-sign-in"></i></h5><small class="description-text">POST INVESTMENT</small>', array('package/apply', 'id'=>$val->id), array('title'=>'Apply Package', 'class'=>'post-investment text-red')); ?>
									</div>
								</div>
							</div>
							<!-- /.row -->
						</div>
					</div>
					<!-- /.widget-user -->
				</div>
			<?php endforeach; ?>
			<div class="col-md-4 col-xs-12 col-sm-6">
				<div class="box box-widget widget-user">
					<div class="widget-user-header <?php //echo $val->class; ?>bg-blue disabled color-palette">
						<h3 class="widget-user-username"><strong>CUSTOM PACKAGE</strong></h3>
						<h5 class="widget-user-desc">Customize your own Package</h5>
					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-sm-12 text-center">
								<div class="description-block">
									<?php echo CHtml::link("<i class='fa fa-plus'></i> CREATE PACKAGE", "javascript:void(0);", array('class'=>'btn btn-lg btn-primary btn-flat', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg')); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="text-center">
					<h2>No Package Available</h2>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Large modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" id="modal-content">
    	
    	<?php 
          $form=$this->beginWidget('CActiveForm', array(
            'id'=>'package-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
          ));
        ?>
    	<div class="modal-header label-danger">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel">
				<strong>Custom Package</strong>
			</h4>
		</div>
		<div class="modal-body">
			<div class="text-center">
				<p class="note">Fields with <span class="required">*</span> are required.</p>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($package, 'amount'); ?>
				<?php echo $form->numberField($package,'amount',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Amount')); ?>
				<?php echo $form->error($package,'amount', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($package, 'interest_rate'); ?>
				<?php echo $form->textField($package,'interest_rate',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Interest Rate (%)')); ?>
				<?php echo $form->error($package,'interest_rate', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($package, 'months_payable'); ?>
				<?php echo $form->numberField($package,'months_payable',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Months Payable')); ?>
				<?php echo $form->error($package,'months_payable', array('style'=>'color: red;')); ?>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-left">
				<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
			</div>
			<div class="pull-right">
				<?php echo CHtml::submitButton($package->isNewRecord ? 'Post Investment' : 'Save', array('class'=>'btn btn-danger btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
			</div>
		</div>

		<?php $this->endWidget(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
	$('#package').addClass('active');

	var button_bool = true;
	$('.post-investment').click(function() {

		if (!button_bool) {
			return false;			
		}

		$(this).removeClass("text-red").addClass("text-yellow").html('<h5><i class="fa fa-spinner fa-spin"></i></h5><small class="description-text">PROCESSING</small>');

		button_bool = false;
	});

	$('#btn-submit').click(function() {
		$(this).removeClass('btn-danger').addClass('btn-warning disabled').val("Processing")
	});

	$('#btn-search').click(function() {
		$('#search-form').submit();
	});
});
</script>