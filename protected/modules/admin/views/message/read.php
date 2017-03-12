<section class="content-header">
    <h1>
        Read Message
    </h1>
    <ol class="breadcrumb">
      <li>
        <?php echo CHtml::link('Mailbox', array('message/index', 'folder'=>'inbox')); ?>
      </li>
      <li class="active">Read Message</li>
    </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-3">
      <?php echo CHtml::link('Compose', array('message/compose'), array('class'=>'btn btn-primary btn-block btn-flat margin-bottom')); ?>

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
              <?php echo CHtml::link('<i class="fa fa-envelope-o"></i> Sent', array('message/index', 'folder'=>'sent')); ?>
            </li>

            <li id="folder_drafts" class="">
              <?php
                if ($drafts_count != 0) {
                  echo CHtml::link('<i class="fa fa-file-text-o"></i> Drafts <span class="label label-warning pull-right">'.$drafts_count.'</span>', array('message/index', 'folder'=>'drafts'));
                } else {
                  echo CHtml::link('<i class="fa fa-file-text-o"></i> Drafts', array('message/index', 'folder'=>'drafts'));
                }
              ?>
            </li>
            
            <li id="folder_trash" class="">
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
        <div class="box-header with-border">
          <h3 class="box-title">Read Mail</h3>

          <div class="box-tools pull-right">
            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
            <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="mailbox-read-info">
            <!-- <h3>Message Subject Is Placed Here</h3> -->
            <h3>From: <?php echo $message->from_account->username; ?>
              <span class="mailbox-read-time pull-right">15 Feb. 2016 11:03 PM</span>
            </h3>
          </div>
          <div class="mailbox-read-message">
            <?php echo nl2br($message->message); ?>
          </div>
          <!-- /.mailbox-read-message -->
        </div>
        <!-- /.box-body -->
        
        <!-- FOR TESTING REMOVE THIS AFTER -->
        <?php if ($message->sent_status == "D" && $message->delete_status != "Y"): ?>
          <div class="box-footer">
            <div class="pull-right">
              <?php //echo CHtml::link('<i class="fa fa-reply"></i> Inbox', array('message/index', 'folder'=>'inbox'), array('class'=>"btn btn-default btn-flat", 'title'=>'Back')); ?>
              <?php echo CHtml::link('<i class="fa fa-envelope"></i> Send', array('message/compose', 'drafts'=>null, 'id'=>$message->id), array('class'=>'btn btn-default btn-flat', 'title'=>'Reply to Admin')) ?>
            </div>
            <?php echo CHtml::link('<i class="fa fa-trash-o"></i> Delete', array('message/trash', 'id'=>$message->id), array('class'=>'btn btn-default btn-flat', 'title'=>'Delete Message', 'confirm'=>'Are you sure you want to Delete this message?')); ?>
          </div>
        <?php endif; ?>

        <!-- /.box-footer -->
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>