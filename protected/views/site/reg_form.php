<script type="text/javascript">
$(document).ready(function() {
	$(document).on('click', '#btn-submit', function() {
		$(this).removeClass('btn-default').addClass('btn-warning disabled').val("Processing");
	});

	$(document).on('keypress', '#reg-form', function(e) {
		if (e.keyCode == 13) {               
		    e.preventDefault();
		    return false;
		}
	});

	$(document).on('change', '#User_category_id', function() {
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
<div class="row">
	<div class="col-md-12">
		<h2 class="heading">Sign Up</h2>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
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
			</div>
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default x-panel">
					<div class="panel-body">
						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'reg-form',
							// Please note: When you enable ajax validation, make sure the corresponding
							// controller action is handling ajax validation correctly.
							// There is a call to performAjaxValidation() commented in generated controller code.
							// See class documentation of CActiveForm for details on this.
							'enableAjaxValidation'=>false,
							'htmlOptions' => array(
								'class'=>'entry-form',
							),
						)); ?>

							<div class="text-center">
								<p class="note">Fields with <span class="required">*</span> are required.</p>
							</div>

							<label>
								<span class="fa fa-cog"></span>
								Account Information
							</label>
							<div class="form-group">
								<?php echo $form->dropDownList($account,'account_type', array(
										'B' =>'Borrower',
										'I' =>'Investor',
									),
									array(
										'prompt' => 'Select Account Type',
										'class'=>'form-control',
										'id'=>'account-type'
									));
								?>
								<?php echo $form->error($account,'account_type', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($account,'username',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Email *')); ?>
								<?php echo $form->error($account,'username', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->passwordField($account,'password',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Password *')); ?>
								<?php echo $form->error($account,'password', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->passwordField($account,'confirm_password',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Confirm Password *')); ?>
								<?php echo $form->error($account,'confirm_password', array('style'=>'color: red;')); ?>
							</div>

							<label>
								<span class="fa fa-user"></span>
								User Information
							</label>
							<div class="form-group">
								<?php echo $form->textField($user,'last_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Last Name *')); ?>
								<?php echo $form->error($user,'last_name', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'first_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'First Name *')); ?>
								<?php echo $form->error($user,'first_name', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'middle_name',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Middle Name')); ?>
								<?php echo $form->error($user,'middle_name', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'address1',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Address 1 *')); ?>
								<?php echo $form->error($user,'address1', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'address2',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Address 2')); ?>
								<?php echo $form->error($user,'address2', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'province',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Province *')); ?>
								<?php echo $form->error($user,'province', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'city',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'City *')); ?>
								<?php echo $form->error($user,'city', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'contact_number',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Contact Number *')); ?>
								<?php echo $form->error($user,'contact_number', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'tin',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Tin Number *')); ?>
								<?php echo $form->error($user,'tin', array('style'=>'color: red;')); ?>
							</div>

							<label>
								<span class="fa fa-book"></span>
								Business Information
							</label>
							<div class="form-group">
								<?php
									echo CHtml::dropDownList('User[category_id]', 'category_id',
										CHtml::listData(BusinessCategory::model()->isActive()->findAll(), 
										'id', 'category'), array('empty' => 'Select Business Category', 'class'=>'form-control'));
								?>
								<div class="error-status"></div>
							</div>

							<div class="form-group">
								<?php
									echo $form->dropDownList($user, 'business_type_id', array(),array('empty' => 'Select Business Type', 'class'=>'form-control'));
								?>
								<?php echo $form->error($user,'business_type_id', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group">
								<?php echo $form->textField($user,'business_name',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Business Name')); ?>
								<?php echo $form->error($user,'business_name', array('style'=>'color: red;')); ?>
							</div>

							<div class="form-group buttons">
								<?php echo CHtml::submitButton($account->isNewRecord ? 'Register Now' : 'Save', array('class'=>'btn btn-default btn-lg', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
							</div>

						<?php $this->endWidget(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>