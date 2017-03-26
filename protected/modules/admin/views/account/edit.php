<section class="content-header">
	<h1>
		<?php echo $user->first_name." ".$user->last_name; ?>
		<small>edit</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link($user->first_name." ".$user->last_name, array('account/edit', 'id'=>$account->id)); ?>
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
		<div class="box-header with-border">

		</div>
		<div class="box-body">
			<?php if ($account->account_type == "B"): ?>
				<!-- HIDDEN VALUES -->
				<input type="hidden" id="category_id" value="<?php echo $user->business_type->category->id; ?>">
				<input type="hidden" id="type_id" value="<?php echo $user->business_type_id; ?>">
			<?php endif; ?>

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

			<div class="text-center">
				<p class="note">Fields with <span class="required">*</span> are required.</p>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="col-md-12">
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
									'class'=>'form-control disable',
									'id'=>'account-type',
									'disabled'=>'disabled'
								));
							?>
							<?php echo $form->error($account,'account_type', array('style'=>'color: red;')); ?>
						</div>

						<div class="form-group">
							<?php echo $form->textField($account,'username',array('size'=>64,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Email *')); ?>
							<?php echo $form->error($account,'username', array('style'=>'color: red;')); ?>
						</div>

						<div class="form-group">
							<?php echo $form->dropDownList($account,'status', array(
									'P' =>'Pending',
									'A' =>'Approved',
									'D' =>'Disabled',
									'R' =>'Rejected',
								),
								array(
									'prompt' => 'Select Account Status',
									'class'=>'form-control',
									'id'=>'account-status'
								));
							?>
							<?php echo $form->error($account,'status', array('style'=>'color: red;')); ?>
						</div>
					</div>
					
					<div class="col-md-12">
						<label>
							<span class="fa fa-book"></span>
							Business Information
						</label>

						<?php if ($account->account_type == "I"): ?>
							<div class="form-group">
								<?php echo $form->textField($user,'check_payable_to',array('size'=>255,'maxlength'=>255, 'class'=>'form-control', 'placeholder'=>'Check payable to')); ?>
								<?php echo $form->error($user,'check_payable_to', array('style'=>'color: red;')); ?>
							</div>
						<?php endif; ?>

						<?php if ($account->account_type == "B"): ?>
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
						<?php endif; ?>
					</div>
				</div>
				<div class="col-md-6">
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
						<?php
					        echo $form->dropDownList($user, 'province',
					          CHtml::listData(Province::model()->findAll(), 
					          'id', 'name'), array('empty' => 'Select Province', 'class'=>'form-control'));
					    ?>
						<?php echo $form->error($user,'province', array('style'=>'color: red;')); ?>
					</div>

					<div class="form-group">
						<?php echo $form->dropDownList($user, 'city', CHtml::listData(City::model()->findAll(array('condition'=>'province_id = :pid', 'params'=>array(':pid'=>$user->province))), 'id', 'name'), array('empty' => 'Select City', 'class'=>'form-control')); ?>
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
				</div>
				<div class="col-md-12">
					<div class="form-group buttons">
						<?php echo CHtml::submitButton($account->isNewRecord ? 'Register Now' : 'Save', array('class'=>'btn btn-primary btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
						<?php echo CHtml::link('Back', array('account/index', 'type'=>$account->account_type, 'status'=>$account->status), array('class'=>'btn btn-danger btn-flat', 'title'=>'Back', 'confirm'=>'Are you sure you want to Discard your Changes?')); ?>
					</div>
				</div>
			</div>

			<?php $this->endWidget(); ?>
		</div>
		<div class="box-footer">

		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function() {
	var category_id = $('#category_id').val();
	var type_id = $('#type_id').val();
	var account_type = "<?php echo $account->account_type; ?>";

	if (account_type == "I") {
		$('#investor_tab_left_side').addClass("active");
	} else {
		$('#borrower_tab_left_side').addClass("active");
	}

	$('#User_category_id').val(category_id);

	$.ajax({
		url: "<?php echo Yii::app()->createUrl('common/listbusinesstype'); ?>",
		data: {cat_id : category_id},
		method: "POST",
		success: function(response) {
			$('#User_business_type_id').html(response);
			$('#User_business_type_id').val(type_id);
		}
	});

	$(document).on('click', '#btn-submit', function() {
		$(this).removeClass('btn-primary').addClass('btn-warning disabled').val('Processing')
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