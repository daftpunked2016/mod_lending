<section class="content-header">
	<h1>
		Welcome Investor!
		<small>dashboard</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Investor', array('account/dashboard')); ?>
		</li>
		<li class="active">Dashboard</li>
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
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo CHtml::encode($inbox_count); ?></h3>

					<p>Inbox</p>
				</div>
				<div class="icon">
					<i class="fa fa-envelope"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('message/index', 'folder'=>'inbox'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo CHtml::encode($packages_count); ?></h3>

					<p>Available Packages</p>
				</div>
				<div class="icon">
					<i class="fa fa-briefcase"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('package/list'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo CHtml::encode($investment_count) ?></h3>

					<p>Investments</p>
				</div>
				<div class="icon">
					<i class="fa fa-share"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('loan/list'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo CHtml::encode($open_count); ?></h3>

					<p>Loan Request</p>
				</div>
				<div class="icon">
					<i class="fa fa-sign-out"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('loan/openlist'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
	</div>
</section>

<script type="text/javascript">
$(function() {
	$('#dashboard').addClass('active');
});
</script>