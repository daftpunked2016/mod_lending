<tr id="<?php echo $data->id; ?>">
	<!-- borrowers -->
	<?php if ($data->account_type == "B"): ?>
		<td>
			<?php echo CHtml::encode($data->user->business_type->type); ?>
		</td>
	<?php endif ?>
	<td>
		<?php echo CHtml::encode($data->user->first_name).' '.CHtml::encode($data->user->last_name); ?>
	</td>
	<td>
		<?php echo CHtml::encode($data->user->contact_number); ?>
	</td>
	<td>
		<?php echo CHtml::encode($data->user->id_name); ?>
	</td>
	<td>
		<?php
			switch ($data->status) {
				case 'P':
					echo "<span class='label label-warning'>Pending</span>";
					break;
				case 'A':
					echo "<span class='label label-success'>Active</span>";
					break;
				case 'D':
					echo "<span class='label label-danger'>Disabled</span>";
					break;
				case 'R':
					echo "<span class='label label-danger'>Rejected</span>";
					break;
			}
		?>
	</td>
	<td class="text-center">
		<div class="btn-group">
          <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-cog"></span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
            	<?php echo CHtml::link('<span class="fa fa-search"></span> View'); ?>
            </li>
            <li>
            	<?php echo CHtml::link('<span class="fa fa-edit"></span> Edit', array('account/edit', 'id'=>$data->id), array('title'=>'Edit Account')); ?>
            </li>
            <li class="divider"></li>
            <li>
	            <?php
		            switch ($data->status) {
		            	case 'P':
		            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('account/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Account?', 'title'=>'Approve Account'));
	            			echo CHtml::link('<span class="fa fa-times"></span> Reject', array('account/reject', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Reject this Account?', 'title'=>'Reject Account'));
		            		break;
		            	case 'A':
		            		echo CHtml::link('<span class="fa fa-ban"></span> Disable', array('account/disable', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Disable this Account?', 'title'=>'Disable Account'));
		            		break;
		            	case 'D':
		            	case 'R':
		            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('account/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Account?', 'title'=>'Approve Account'));
		            		echo CHtml::link('<span class="fa fa-trash"></span> Delete', array('account/delete', 'id'=>$data->id), array('confirm'=>"Are you sure you want to Delete this Account?\n\nNote: This action can not be undone", 'title'=>'Delete Account'));
		            		break;
		            }
	            ?>
            </li>
          </ul>
    	</div>
	</td>
</tr>