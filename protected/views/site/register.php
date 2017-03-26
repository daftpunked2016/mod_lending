<style> 
.file { visibility: hidden; position: absolute; } 
.filename-upload-container:disabled { background-color: #FFF; }
</style>

<?php 
  foreach(Yii::app()->user->getFlashes() as $key=>$message) {
    if($key === 'success') {
      echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> Alert!</h4>
              '.$message.'
            </div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              '.$message.'
            </div>';
    }
  }
?>

<!-- <p class="login-box-msg">Register a new membership</p> -->
<p class="note text-center">Fields with <span class="required">*</span> are required.</p>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'reg-form',
  // Please note: When you enable ajax validation, make sure the corresponding
  // controller action is handling ajax validation correctly.
  // There is a call to performAjaxValidation() commented in generated controller code.
  // See class documentation of CActiveForm for details on this.
  'enableAjaxValidation'=>false,
  'htmlOptions'=>['enctype'=>'multipart/form-data']
)); ?>

  <div class="form-group has-feedback">
    <!-- <input type="text" class="form-control" placeholder="Full name"> -->
    <?php echo $form->textField($account,'username',array('size'=>40,'maxlength'=>40, 'class'=>'form-control', 'placeholder'=>'Email *')); ?>
    <?php echo $form->error($account,'username', array('class'=>'text-red')); ?>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
    <?php echo $form->passwordField($account,'password',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Password *')); ?>
    <?php echo $form->error($account,'password', array('class'=>'text-red')); ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
    <?php echo $form->passwordField($account,'confirm_password',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Retype password *')); ?>
    <?php echo $form->error($account,'confirm_password', array('class'=>'text-red')); ?>
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'first_name',array('size'=>60,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'First name *')); ?>
      <?php echo $form->error($user,'first_name', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'middle_name',array('size'=>60,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Middle name')); ?>
      <?php echo $form->error($user,'middle_name', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'last_name',array('size'=>60,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Last name *')); ?>
      <?php echo $form->error($user,'last_name', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-user form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'address1',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Address 1 *')); ?>
      <?php echo $form->error($user,'address1', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'address2',array('size'=>60,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Address 2 (optional)')); ?>
      <?php echo $form->error($user,'address2', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php
        echo $form->dropDownList($user, 'province',
          CHtml::listData(Province::model()->findAll(), 
          'id', 'name'), array('empty' => 'Select Province', 'class'=>'form-control'));
      ?>
      <?php echo $form->error($user,'province', array('class'=>'text-red')); ?>
      <!-- <span class="glyphicon glyphicon-map-marker form-control-feedback"></span> -->
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->dropDownList($user, 'city', array(), array('empty' => 'Select City', 'class'=>'form-control')); ?>
      <?php echo $form->error($user,'city', array('class'=>'text-red')); ?>
      <!-- <span class="glyphicon glyphicon-map-marker form-control-feedback"></span> -->
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'contact_number',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Contact number *')); ?>
      <?php echo $form->error($user,'contact_number', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'tin',array('size'=>32,'maxlength'=>32, 'class'=>'form-control', 'placeholder'=>'Tin * (00-0000000)')); ?>
      <?php echo $form->error($user,'tin', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-th form-control-feedback"></span>
  </div>

  <?php if ($type == "I"): ?>
    <div class="form-group has-feedback">
        <?php echo $form->textField($user,'check_payable_to',array('size'=>255,'maxlength'=>255, 'class'=>'form-control', 'placeholder'=>'Check payable to')); ?>
        <?php echo $form->error($user,'check_payable_to', array('class'=>'text-red')); ?>
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
    </div>
  <?php endif; ?>

  <?php if ($type == "B"): ?>
  <div class="form-group has-feedback">
      <?php
        echo $form->dropDownList($user, 'business_category',
          CHtml::listData(BusinessCategory::model()->isActive()->findAll(), 
          'id', 'category'), array('empty' => 'Select Business Category', 'class'=>'form-control'));
      ?>
      <?php echo $form->error($user,'business_category', array('class'=>'text-red')); ?>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->dropDownList($user, 'business_type_id', array(), array('empty' => 'Select Business Type', 'class'=>'form-control')); ?>
      <?php echo $form->error($user,'business_type_id', array('class'=>'text-red')); ?>
  </div>

  <div class="form-group has-feedback">
      <?php echo $form->textField($user,'business_name',array('size'=>60,'maxlength'=>64, 'class'=>'form-control', 'placeholder'=>'Business name *')); ?>
      <?php echo $form->error($user,'business_name', array('class'=>'text-red')); ?>
      <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
  </div>
  <?php endif; ?>

  <?php if ($type == "B"): ?>
  <div class="form-group has-feedback">
    <label>DTI File *</label>
    <input type="file" name="dti_file" class="file">
    <div class="input-group col-xs-12">
      <span class="input-group-btn">
        <button class="browse btn btn-default" type="button"><i class="glyphicon glyphicon-plus"></i> Select File </button>
      </span>
      <input type="text" class="form-control filename-upload-container" disabled placeholder="No file selected..">
    </div>
    <?php echo $form->error($user,'dti_file_id', array('class'=>'text-red')); ?>
  </div>

  <div class="form-group has-feedback">
    <label>SEC File *</label>
    <input type="file" name="sec_file" class="file">
    <div class="input-group col-xs-12">
      <span class="input-group-btn">
        <button class="browse btn btn-default" type="button"><i class="glyphicon glyphicon-plus"></i> Select File </button>
      </span>
      <input type="text" class="form-control filename-upload-container" disabled placeholder="No file selected..">
    </div>
    <?php echo $form->error($user,'sec_file_id', array('class'=>'text-red')); ?>
  </div>

  <label>Other Supporting Documents</label>
    <?php for($x=0; $x < 3; $x++): ?>
      <div class="form-group has-feedback">
        <input type="file" name="supporting_documents[<?= $x; ?>]" class="file">
        <div class="input-group col-xs-12">
          <span class="input-group-btn">
            <button class="browse btn btn-default" type="button"><i class="glyphicon glyphicon-plus"></i> Select File </button>
          </span>
          <input type="text" class="form-control filename-upload-container" disabled placeholder="No file selected..">
        </div>
      </div>
    <?php endfor; ?>
  <?php else: ?>
  <label>Supporting Documents</label>
    <?php for($x=0; $x < 5; $x++): ?>
      <div class="form-group has-feedback">
        <input type="file" name="supporting_documents[<?= $x; ?>]" class="file">
        <div class="input-group col-xs-12">
          <span class="input-group-btn">
            <button class="browse btn btn-default" type="button"><i class="glyphicon glyphicon-plus"></i> Select File </button>
          </span>
          <input type="text" class="form-control filename-upload-container" disabled placeholder="No file selected..">
        </div>
      </div>
    <?php endfor; ?>
  <?php endif; ?>

  <div class="form-group has-feedback">
    <p class="text-muted">
      <small><strong>NOTE:</strong> 
      <?php if($type == "B"): ?>
        <em>* File/s must only be in PDF or JPEG format.</em>
      <?php else: ?>
        <br /><em>* File/s must only be in PDF or JPEG format.</em> <br />
        <em>* At least <strong>2 files</strong> must be uploaded.</em>
      <?php endif; ?>
      </small>
    </p>
  </div>

  <div class="row">
    <!-- <div class="col-xs-8">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox"> I agree to the <a href="#">terms</a>
        </label>
      </div>
    </div> -->
    <!-- /.col -->
    <div class="col-md-4 col-xs-6 col-sm-4">
      <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
      <?php echo CHtml::link('Back', array('site/register'), array('class'=>'btn btn-danger btn-block btn-flat')); ?>
    </div>

    <div class="col-md-4 col-xs-6 col-sm-4"></div>

    <div class="col-md-4 col-xs-6 col-sm-4">
      <?php echo CHtml::submitButton($account->isNewRecord ? 'Register' : 'Save', array('class'=>'btn btn-primary btn-block btn-flat', 'id'=>'btn-submit')); ?>
    </div>
    <!-- /.col -->
  </div>
<?php $this->endWidget(); ?>
<br>
<div class="text-center">
  <?php echo CHtml::link('I already have an Account', array('site/login')); ?>
</div>

<script type="text/javascript">
$(document).ready(function() {

  var business_category = $('#User_business_category').val();
  var province = $('#User_province').val();
  var city = "<?php echo $user->city; ?>"
  var business_type = "<?php echo $user->business_type_id; ?>";
  var account_type = "<?= $type; ?>"

  if (business_category) {
    $.ajax({
      url: "<?php echo Yii::app()->createUrl('common/listbusinesstype'); ?>",
      data: {cat_id : business_category},
      method: "POST",
      success: function(response) {
        $('#User_business_type_id').html(response);

        if (business_type) {
          $('#User_business_type_id').val(business_type);
        }
      }
    });
  };

  if (province) {
    $.ajax({
      url: "<?php echo Yii::app()->createUrl('common/listcities'); ?>",
      data: {province_id : province},
      method: "POST",
      success: function(response) {
        $('#User_city').html(response);

        if (city) {
          $('#User_city').val(city);
        }
      }
    });
  };

  $(document).on('click', '#btn-submit', function(event) {
    var loaded_files = 0;
    $('.file').each(function() {
      if ($(this).get(0).files.length) {
          loaded_files++
      }
    });

    if(account_type != 'B' && loaded_files < 2) {
      alert('Minimum of 2 document files must be uploaded.');
      event.preventDefault();
    } else {
      $(this).removeClass('btn-primary').addClass('btn-warning disabled').val("Processing");
    }
  });

  $(document).on('keypress', '#reg-form', function(e) {
    if (e.keyCode == 13) {               
        e.preventDefault();
        return false;
    }
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

  $(document).on('click', '.browse', function(){
    var file = $(this).parent().parent().parent().find('.file');
    file.trigger('click');
  });

  $(document).on('change', '.file', function(){
      var errors = 0;
      var val = $(this).val();
      var file_size =  parseFloat(this.files[0].size/1024/1024).toFixed(2);

      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
          case 'jpg':
          case 'jpeg':
          case 'pdf':
              break;
          default:
              errors++;
              $(this).val('');
              // error message here
              alert("Invalid File! File must be JPEG and PDF format only.");
              break;
      }

      if(file_size > 5) {
        errors++
        $(this).val('');
        alert("The image you are trying to upload exceeds the Maximum file size (5MB) limit.")
      }

      if(errors == 0) {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
      }
  });

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

});
</script>