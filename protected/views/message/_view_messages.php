<tr>
	<td class="mailbox-name">
		<?php echo CHtml::link($data->from_account->username, array('message/read', 'id'=>$data->id)); ?>
	</td>
	<td class="mailbox-date">
		<?php echo $data->date_created; ?>
	</td>
	<td>
		<?php 
			if ($data->seen_status == "U") {
				echo "<label class='label label-danger'>Unread</label>";
			} else {
				echo "<label class='label label-success'>Read</label>";
			}
		?>
	</td>
	<td class="text-center">
		<!-- <div class="btn-group">
          <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-cog"></span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
            	<?php //echo CHtml::link('<span class="fa fa-search"></span> Read Message', array('message/read', 'id'=>$data->id)); ?>
            </li>
          </ul>
    	</div> -->
    	<?php echo CHtml::link('<span class="fa fa-search"></span> Read Message', array('message/read', 'id'=>$data->id), array('class'=>'btn-sm btn-info', 'title'=>'Read Message')); ?>
	</td>
</tr>