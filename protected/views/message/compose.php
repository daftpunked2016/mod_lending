<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<section class="content-header">
    <h1>
        Mailbox
        <small>compose</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <?php echo CHtml::link('Mailbox', array('message/index', 'folder'=>'inbox')); ?>
        </li>
        <li class="active">Compose</li>
    </ol>
</section>

<section class="content-header">
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
</section>

<section class="content">
  <div class="row">
    <div class="col-md-3">
      <?php echo CHtml::link('Back to Inbox', array('message/index', 'folder'=>'inbox'), array('class'=>'btn btn-primary btn-block btn-flat margin-bottom')); ?>

      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>

          <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li id="folder_inbox" class="">
              <?php
                if ($inbox_count != 0) {
                  echo CHtml::link('<i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right">'.$inbox_count.'</span>', array('message/index', 'folder'=>'inbox')); 
                } else {
                  echo CHtml::link('<i class="fa fa-inbox"></i> Inbox', array('message/index', 'folder'=>'inbox')); 
                }
              ?>
            </li>
            
            <li id="folder_sent" class="">
              <!-- <span class="label label-success pull-right">12</span> -->
              <?php echo CHtml::link('<i class="fa fa-envelope-o"></i> Sent', array('message/index', 'folder'=>'sent')); ?>
            </li>

            <li id="folder_drafts" class="">
              <!-- <span class="label label-warning pull-right">12</span> -->
              <?php
                if ($drafts_count != 0) {
                  echo CHtml::link('<i class="fa fa-file-text-o"></i> Drafts <span class="label label-warning pull-right">'.$drafts_count.'</span>', array('message/index', 'folder'=>'drafts'));
                } else {
                  echo CHtml::link('<i class="fa fa-file-text-o"></i> Drafts', array('message/index', 'folder'=>'drafts'));
                }
              ?>
            </li>
            
            <li id="folder_trash" class="">
              <!-- <span class="label label-danger pull-right">12</span> -->
              <?php echo CHtml::link('<i class="fa fa-trash-o"></i> Trash', array('message/index', 'folder'=>'trash')); ?>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="box box-primary">
        <?php 
          $form=$this->beginWidget('CActiveForm', array(
            'id'=>'compose-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
          ));
        ?>
        <div class="box-header with-border">
          <h3 class="box-title">Compose New Message</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <div class="form-group">
            <input class="form-control" placeholder="To:">
          </div>
          <div class="form-group">
            <input class="form-control" placeholder="Subject:">
          </div> -->
          <div class="form-group">
            <?php echo $form->textArea($message,'message',array('size'=>32,'maxlength'=>32, 'style'=>'height: 300px;', 'class'=>'form-control', 'placeholder'=>'Enter your Message here', 'id'=>'compose-textarea')); ?>
            <?php echo $form->error($message,'message', array('style'=>'color: red;')); ?>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <a id="btn-drafts" href="javascript:void(0);" data-target="<?php echo Yii::app()->createUrl('message/compose', array('drafts'=>'true')) ?>" class="btn btn-warning btn-flat"><i class="fa fa-pencil"></i> Drafts</a>
            <?php echo CHtml::submitButton($message->isNewRecord ? 'Send' : 'Save', array('class'=>'btn btn-primary btn-flat')); ?>
          </div>
          <?php echo CHtml::link('<i class="fa fa-times"></i> Discard', array('message/index', 'folder'=>'inbox'), array('class'=>'btn btn-default btn-flat', 'confirm'=>"Are you sure you want to discard your changes? \n\n Click \"OK\" to proceed.")); ?>
        </div>
        <!-- /.box-footer -->
      <?php $this->endWidget(); ?>
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<script>
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();

    $('#btn-drafts').click(function() {
      $('#compose-form').attr('action', $(this).data('target'));
      $('#compose-form').submit();
    });
  });
</script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>