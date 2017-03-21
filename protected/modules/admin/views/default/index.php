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
		Welcome!
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
	
</section>

<script type="text/javascript">
$(function() {
	$('#dashboard').addClass('active');
});
</script>