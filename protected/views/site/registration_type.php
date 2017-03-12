<style type="text/css">
.register-box {
	width: 700px !important;
}
</style>

<p class="text-center">Select Registration Type</p>

<div class="row">
	<div class="col-md-6">
		<div class="small-box bg-blue">
	        <div class="inner">
	        	<h3 class="fa fa-user"></h3>

	        	<p>Borrower</p>
	        </div>

	        <div class="icon">
	        	<i class="fa fa-user"></i>
	        </div>

	        <?php echo CHtml::link('Register Now <i class="fa fa-arrow-circle-right"></i>', array('site/register', 'type'=>'B'), array('class'=>'small-box-footer')); ?>
        </div>
        <p>
        	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
	</div>
	<div class="col-md-6">
		<div class="small-box bg-red">
	        <div class="inner">
	        	<h3 class="fa fa-suitcase"></h3>

	        	<p>Investor</p>
	        </div>

	        <div class="icon">
	        	<i class="fa fa-suitcase"></i>
	        </div>

	        <?php echo CHtml::link('Register Now <i class="fa fa-arrow-circle-right"></i>', array('site/register', 'type'=>'I'), array('class'=>'small-box-footer')); ?>
        </div>
        <p>
        	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
	</div>
</div>

<div class="text-center">
	<?php echo CHtml::link('I already have a membership', array('site/login')); ?>
</div>