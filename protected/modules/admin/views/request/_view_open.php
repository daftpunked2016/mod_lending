<?php $package = $data->package; ?>

<tr>
	<td><b><?php echo CHtml::encode($data->account->user->id_name); ?></b></td>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?> month/s</td>
	<td>
		<?php
			if ($data->loan_id) {
				echo CHtml::link('View Invitation', "javascript:void(0);", array('class'=>'btn-sm btn-primary'));
			} else {
				echo "<span class='label label-warning'> Pending </span>";
			}
		?>
	</td>
	<td>
		<?php
			switch ($data->status) {
				case 'A':
					echo "<label class='label label-success'>Approved</label>";
					break;
				case 'P':
					echo "<label class='label label-warning'>Pending</label>";
					break;
				default:
					echo "<label class='label label-danger'>Rejected</label>";
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
            	<?php echo CHtml::link('<span class="fa fa-search"></span> View', 'javascript:void(0);', array('class'=>'view-account', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'data-url'=>Yii::app()->createUrl('admin/account/view', array('id'=>$data->borrower_id)))); ?>
            </li>
            <li class="divider"></li>
            <li>
	            <?php
		            switch ($data->status) {
		            	case 'P':
		            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('request/approverequest', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Request?', 'title'=>'Approve Request'));
	            			echo CHtml::link('<span class="fa fa-times"></span> Reject', array('request/rejectrequest', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Reject this Request?', 'title'=>'Reject Request'));
		            		break;
		            	case 'A':
		            		echo CHtml::link('<span class="fa fa-times"></span> Reject', array('request/rejectrequest', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Reject this Request?', 'title'=>'Reject Request'));
		            		break;
		            	case 'R':
		            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('request/approverequest', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Request?', 'title'=>'Approve Request'));
		            		echo CHtml::link('<span class="fa fa-trash"></span> Delete', array('request/deleterequest', 'id'=>$data->id), array('confirm'=>"Are you sure you want to Delete this Request?\n\nNote: This action can not be undone", 'title'=>'Delete Request'));
		            		break;
		            }
	            ?>
            </li>
          </ul>
    	</div>
	</td>
</tr>