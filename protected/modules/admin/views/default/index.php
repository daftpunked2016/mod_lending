<section class="content-header">
	<?php 
		foreach(Yii::app()->user->getFlashes() as $key=>$message) {
			if($key  === 'success') {
				echo "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
				$message.'</div>';
			} else {
				echo "<div class='alert alert-danger alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
				$message.'</div>';
			}
		}
	?>
	<h1>
		Welcome <?php echo $user->first_name; ?>!
		<small>dashboard</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Dashboard', array('default/index')); ?>
		</li>
		<li class="active">View</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $total_investor; ?></h3>

					<p>Investors</p>
				</div>
				<div class="icon">
					<i class="fa fa-briefcase"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('account/index', 'type'=>'I', 'status'=>'P'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $total_borrower; ?></h3>

					<p>Borrowers</p>
				</div>
				<div class="icon">
					<i class="fa fa-user"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('account/index', 'type'=>'B', 'status'=>'P'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $total_investment; ?></h3>

					<p>Investments</p>
				</div>
				<div class="icon">
					<i class="fa fa-share"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('loan/list', 'status'=>'A'), array('class'=>'small-box-footer')); ?>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $total_loan; ?></h3>

					<p>Loans</p>
				</div>
				<div class="icon">
					<i class="fa fa-sign-in"></i>
				</div>
				<?php echo CHtml::link('More info <i class="fa fa-arrow-circle-right"></i>', array('request/index', 'status'=>'A'), array('class'=>'small-box-footer')); ?>
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