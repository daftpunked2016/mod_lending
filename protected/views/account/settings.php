<section class="content-header">
	<h1>
		Settings
		<small>account</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Settings', array('account/settings')); ?>
		</li>
		<li class="active">Account</li>
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
		<div class="box-body">
			<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'settings-form',
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
			<p>Fields with <span class="required">*</span> are required.</p>
			<hr>
			<div class="row">
				<div class="col-md-6" style="border-right: 1px solid #eee;">
					<p>Account Details</p>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($account, 'username'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($account,'username',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Username / Email *')); ?>
							<?php echo $form->error($account,'username', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'first_name'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'first_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'First Name *')); ?>
							<?php echo $form->error($user,'first_name', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'middle_name'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'middle_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Middle Name')); ?>
							<?php echo $form->error($user,'middle_name', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'last_name'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'last_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Last Name *')); ?>
							<?php echo $form->error($user,'last_name', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<hr>
					<p>Password Details</p>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($account, 'current_password'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->passwordField($account,'current_password',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Current Password')); ?>
							<?php echo $form->error($account,'current_password', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($account, 'new_password'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->passwordField($account,'new_password',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'New Password')); ?>
							<?php echo $form->error($account,'new_password', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($account, 'confirm_password'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->passwordField($account,'confirm_password',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Confirm Password')); ?>
							<?php echo $form->error($account,'confirm_password', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
				</div>
				<div class="col-md-6">
					<p>Contact Details</p>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'address1'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'address1',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Address 1 *')); ?>
							<?php echo $form->error($user,'address1', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'address2'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'address2',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Address 2')); ?>
							<?php echo $form->error($user,'address2', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'province'); ?>
						</div>
						<div class="col-md-8">
							<?php
						        echo $form->dropDownList($user, 'province',
						          CHtml::listData(Province::model()->findAll(), 
						          'id', 'name'), array('empty' => 'Select Province', 'class'=>'form-control'));
						    ?>
							<?php echo $form->error($user,'province', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'city'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->dropDownList($user, 'city', CHtml::listData(City::model()->findAll(array('condition'=>'province_id = :pid', 'params'=>array(':pid'=>$user->province))), 'id', 'name'), array('empty' => 'Select City', 'class'=>'form-control')); ?>
							<?php echo $form->error($user,'city', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'contact_number'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'contact_number',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Contact Number *')); ?>
							<?php echo $form->error($user,'contact_number', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<?php echo $form->labelEx($user, 'tin'); ?>
						</div>
						<div class="col-md-8">
							<?php echo $form->textField($user,'tin',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'TIN * (00-000000)')); ?>
							<?php echo $form->error($user,'tin', array('style'=>'color: red;')); ?>
						</div>
					</div>
					<?php if ($account->account_type == "I"): ?>
						<br>
						<div class="row">
							<div class="col-md-4">
								<?php echo $form->labelEx($user, 'check_payable_to'); ?>
							</div>
							<div class="col-md-8">
								<?php echo $form->textField($user,'check_payable_to',array('size'=>255,'maxlength'=>255, 'class'=>'form-control', 'placeholder'=>'Check payable to')); ?>
								<?php echo $form->error($user,'check_payable_to', array('style'=>'color: red;')); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($account->account_type == "B"): ?>
						<hr>
						<p>Business Details</p>
						<br>
						<div class="row">
							<div class="col-md-4">
								<?php echo $form->labelEx($user, 'business_category'); ?>
							</div>
							<div class="col-md-8">
								<?php
							        echo $form->dropDownList($user, 'business_category',
							          CHtml::listData(BusinessCategory::model()->isActive()->findAll(), 
							          'id', 'category'), array('empty' => 'Select Business Category', 'class'=>'form-control'));
							    ?>
								<?php echo $form->error($user,'business_category', array('style'=>'color: red;')); ?>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-4">
								<?php echo $form->labelEx($user, 'business_type_id'); ?>
							</div>
							<div class="col-md-8">
								<?php
							        echo $form->dropDownList($user, 'business_type_id',
							          CHtml::listData(BusinessType::model()->isActive()->findAll(array('condition'=>'cat_id = :cid', 'params'=>array(':cid'=>$user->business_category))), 
							          'id', 'type'), array('empty' => 'Select Business Category', 'class'=>'form-control'));
							    ?>
								<?php echo $form->error($user,'business_type_id', array('style'=>'color: red;')); ?>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-4">
								<?php echo $form->labelEx($user, 'business_name'); ?>
							</div>
							<div class="col-md-8">
								<?php echo $form->textField($user,'business_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Business Name')); ?>
								<?php echo $form->error($user,'business_name', array('style'=>'color: red;')); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<?php echo CHtml::link("Back", array('default/index'), array('title'=>'Back', 'class'=>'btn btn-danger btn-flat')) ?>
			<div class="pull-right">
				<?php echo CHtml::submitButton($account->isNewRecord ? 'Register' : 'Save', array('class'=>'btn btn-primary btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function() {
	$(document).on('change', '#User_province', function() {
	    var province_id = $(this).val();

	    $.ajax({
			url: "<?php echo Yii::app()->createUrl('common/listcities'); ?>",
			method: 'POST',
			data: {province_id : province_id},
			success: function(response) {
				$('#User_city').html(response);
			}
	    });
	});

	$(document).on('change', '#User_business_category', function() {
	    var cat_id = $(this).val();

	    $.ajax({
	      url: "<?php echo Yii::app()->createUrl('common/listbusinesstype'); ?>",
	      data: {cat_id : cat_id},
	      method: "POST",
	      success: function(response) {
	        $('#User_business_type_id').html(response);
	      }
	    });
	});
});
</script>