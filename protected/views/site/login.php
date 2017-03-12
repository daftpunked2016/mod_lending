<?php 
  foreach(Yii::app()->user->getFlashes() as $key=>$message) {
    if($key === 'success') {
      echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> Success!</h4>
              '.$message.'
            </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Error!</h4>
              '.$message.'
            </div>';
    }
  }
?>

<p class="login-box-msg">Sign in to start your session</p>

<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	));
?>
	<div class="form-group has-feedback">
		<?php echo $form->textField($model,'username', array('class'=>'form-control', 'placeholder'=>'Email')); ?>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	</div>

	<div class="form-group has-feedback">
		<?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>

	<div class="row">
		<div class="col-xs-8">
			<div class="checkbox icheck">
				<label>
					<?php echo $form->checkBox($model,'rememberMe'); ?>
					<?php echo $form->label($model,'rememberMe'); ?>
					<?php echo $form->error($model,'rememberMe'); ?>
				</label>
			</div>
		</div>

		<div class="col-xs-4">
			<?php echo CHtml::submitButton('Sign in', array('class'=>'btn btn-primary btn-block btn-flat')); ?>
		</div>

	</div>
<?php $this->endWidget(); ?>

<!-- <div class="social-auth-links text-center">
	<p>- OR -</p>
	<a href="#" class="btn btn-block btn-social btn-facebook btn-flat">
		<i class="fa fa-facebook"></i> Sign in using Facebook
	</a>
	<a href="#" class="btn btn-block btn-social btn-google btn-flat">
		<i class="fa fa-google-plus"></i> Sign in using Google+
	</a>
</div>

<a href="#">I forgot my password</a><br> -->
<?php echo CHtml::link('Register here for membership', array('site/register')); ?>