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
		<?php foreach ($packages as $val): ?>
			<div class="col-md-4">
				<!-- Widget: user widget style 1 -->
				<div class="box box-widget widget-user">
					<!-- Add the bg color to the header using any of the bg-* classes -->
					<div class="widget-user-header <?php echo $val->class; ?>">
						<h3 class="widget-user-username">P <?php echo number_format($val->amount, 2); ?></h3>
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
	</div>
</section>

<script type="text/javascript">
$(function() {
	$('#package').addClass('active');

	$('.post-investment').click(function() {
		$(this).removeClass("text-red").addClass("text-yellow").html('<h5><i class="fa fa-spinner fa-spin"></i></h5><small class="description-text">PROCESSING</small>')
	});
});
</script>