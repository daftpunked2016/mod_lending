<section class="content-header">
	<h1>
		Mailbox
		<small><?php echo $folder; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Mailbox', array('message/index', 'folder'=>$folder)); ?>
		</li>
		<li class="active"><?php echo ucfirst($folder); ?></li>
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
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo ucfirst($folder); ?></h3>

					<div class="box-tools pull-right">
						<div class="has-feedback">
							<input type="text" class="form-control input-sm" placeholder="Search Mail">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<div class="table-responsive mailbox-messages">
						<?php
							$this->widget('zii.widgets.CListView', array(
		      					'dataProvider'=>$messagesDP,
		      					'itemView'=>'_view_messages',
		      					'template' => "{sorter}
		      					<table class='table table-hover table-striped'>
		      						<thead class='panel-heading'>
		      							<th>From</th>
		      							<th>Date Created</th>
		      							<th>Status</th>
		      							<th class='text-center'>Actions</th>
		      						</thead>
		      						<tbody>
		      							{items}
		      						</tbody>
		      					</table>
		      					{pager}",
		      					'emptyText' => "<tr><td class='text-center' colspan=\"4\">No messages available</td></tr>",
		      				));
						?>
						<!-- /.table -->
					</div>
					<!-- /.mail-box-messages -->
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /. box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>

<script type="text/javascript">
$(function() {

	// Method adding of active class
	$('#mailbox').addClass('active');

	$('#folder_<?php echo $folder ?>').addClass('active');

	//Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });
});
</script>