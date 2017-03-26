<section class="content-header">
	<h1>
		<?php echo $content->description; ?>
		<small>edit</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link($content->description, array('content/edit', 'id'=>$content->id)); ?>
		</li>
		<li class="active">Edit</li>
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
			'htmlOptions' => array(
				'class'=>'entry-form',
			),
		)); ?>
		<div class="box-body">
			<div class="text-center">
				<p class="note">Fields with <span class="required">*</span> are required.</p>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($content, 'description'); ?>
				<?php echo $form->textField($content,'description',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Description', 'disabled'=>'disabled')); ?>
				<?php echo $form->error($content,'description', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($content, 'content'); ?>
				<?php echo $form->textArea($content,'content',array('class'=>'form-control', 'rows'=>20, 'placeholder'=>'Content')); ?>
				<?php echo $form->error($content,'content', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($content, 'status'); ?>
				<?php echo $form->dropDownList($content,'status', array(
						'A' =>'Activate',
						'D' =>'Disable',
					),
					array(
						'prompt' => 'Select Content Status',
						'class'=>'form-control',
					));
				?>
				<?php echo $form->error($content,'status', array('style'=>'color: red;')); ?>
			</div>
		</div>
		<div class="box-footer">
			<?php echo CHtml::link("Back", array('content/index'), array('title'=>'Back', 'class'=>'btn btn-danger btn-flat')) ?>
			<div class="pull-right">
				<?php echo CHtml::submitButton($content->isNewRecord ? 'Register Now' : 'Save', array('class'=>'btn btn-primary btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
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