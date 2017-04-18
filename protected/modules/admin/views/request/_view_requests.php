<?php $package = $data->loan->package; ?>

<tr>
	<td><strong><?php echo CHtml::encode($data->account->user->id_name); ?></strong></td>
	<td><?php echo CHtml::encode(strtoupper($package->package_name)); ?></td>
	<td><?php echo CHtml::encode($package->interest_rate * 100); ?>%</td>
	<td><?php echo CHtml::encode($package->months_payable); ?></td>
	<td>
		<?php
			switch ($data->status) {
				case 'P':
					echo "<label class='label label-warning'> Pending </label>";
					break;
				case 'A':
					echo "<label class='label label-success'> Approved </label>";
					break;
				case 'R':
					echo "<label class='label label-danger'> Rejected </label>";
					break;
				default:
					echo "<label class='label label-default'> Open </label>";
					break;
			}
		?>
	</td>
	<?php if ($data->status != "O"): ?>
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
			            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('request/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Request?', 'title'=>'Approve Request'));
		            			echo CHtml::link('<span class="fa fa-times"></span> Reject', array('request/reject', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Reject this Request?', 'title'=>'Reject Request'));
			            		break;
			            	case 'A':
			            		echo CHtml::link('<span class="fa fa-times"></span> Reject', array('request/reject', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Reject this Request?', 'title'=>'Reject Request'));
			            		break;
			            	case 'R':
			            		echo CHtml::link('<span class="fa fa-check"></span> Approve', array('request/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Approve this Request?', 'title'=>'Approve Request'));
			            		echo CHtml::link('<span class="fa fa-trash"></span> Delete', array('request/delete', 'id'=>$data->id), array('confirm'=>"Are you sure you want to Delete this Request?\n\nNote: This action can not be undone", 'title'=>'Delete Request'));
			            		break;
			            }
		            ?>
	            </li>
	          </ul>
	    	</div>
		</td>
	<?php endif; ?>
</tr>