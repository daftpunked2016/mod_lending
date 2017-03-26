<section class="content-header">
	<h1>
		<?php echo ucfirst($package->package_name); ?> Package
		<small>edit</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link(ucfirst($package->package_name), array('package/edit', 'id'=>$package->id)); ?>
		</li>
		<li class="active">Create</li>
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
	<div class="box">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'edit-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>
		<div class="box-body">
			<div class="text-center">
				<p class="note">Fields with <span class="required">*</span> are required.</p>
			</div>
			<div class="row">
				<div class="col-md-3">
					<?php echo $form->labelEx($package, 'package_name'); ?>
					<?php echo $form->textField($package,'package_name',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Package Name')); ?>
					<?php echo $form->error($package,'package_name', array('style'=>'color: red;')); ?>
				</div>

				<div class="col-md-3">
					<?php echo $form->labelEx($package, 'amount'); ?>
					<?php echo $form->numberField($package,'amount',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Amount')); ?>
					<?php echo $form->error($package,'amount', array('style'=>'color: red;')); ?>
				</div>

				<div class="col-md-3">
					<?php echo $form->labelEx($package, 'interest_rate'); ?>
					<?php echo $form->textField($package,'interest_rate',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Interest Rate (%)')); ?>
					<?php echo $form->error($package,'interest_rate', array('style'=>'color: red;')); ?>
				</div>

				<div class="col-md-3">
					<?php echo $form->labelEx($package, 'months_payable'); ?>
					<?php echo $form->numberField($package,'months_payable',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Months Payable')); ?>
					<?php echo $form->error($package,'months_payable', array('style'=>'color: red;')); ?>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<?php echo CHtml::link("Back", array('package/index'), array('title'=>'Back', 'class'=>'btn btn-danger btn-flat', 'confirm'=>'Are you sure you want to Discard your Changes?')) ?>
			<div class="pull-right">
				<?php echo CHtml::submitButton($package->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
		$('#content_management').addClass('active');
	});
</script>