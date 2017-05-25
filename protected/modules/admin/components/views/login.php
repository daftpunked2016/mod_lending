<?php $baseUrl = Yii::app()->request->baseUrl; ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,	
	),
)); ?>
<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
  if($key  === 'success')
    {
      echo "<div class='alert alert-success alert-dismissible' role='alert' style='margin-bottom:5px'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
    }
    else
    {
      echo "<div class='alert alert-danger alert-dismissible' role='alert' style='margin-bottom:5px'>
      <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
      $message.'</div>';
    }
  }
?>

<div class="form-group has-feedback">
	<?php echo $form->textField($model,'username', array('class'=>'form-control', 'type'=>'email', 'placeholder'=>'Email')); ?><span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	<?php echo $form->error($model,'username', array('class'=>'text-red')); ?>
	
</div>

<div class="form-group has-feedback">
  <?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?><span class="glyphicon glyphicon-lock form-control-feedback"></span>
  <?php echo $form->error($model,'password', array('class'=>'text-red')); ?>
</div>

<div class="form-group has-feedback">
  <div class="checkbox icheck">
    <label>
      <?php echo $form->checkBox($model,'rememberMe'); ?>
      <?php echo $form->label($model,'rememberMe'); ?>
      <?php echo $form->error($model,'rememberMe'); ?>
    </label>
  </div>
</div>

<div class="form-group has-feedback">
	<?php echo CHtml::submitButton('Sign in', array('class'=>'btn btn-primary btn-block btn-flat')); ?>
</div>
<?php $this->endWidget(); ?>