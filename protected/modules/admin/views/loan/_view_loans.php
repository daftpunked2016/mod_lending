<?php 
	$package = $data->package;
	$user = $data->account->user;
?>
<tr>
	<td>
		<?php echo CHtml::encode($user->first_name)." ".CHtml::encode($user->last_name); ?>
		<small>
			(<strong><?php echo CHtml::encode($user->id_name); ?></strong>)
		</small>
	</td>
	<td><?php echo CHtml::encode(strtoupper($package->package_name)); ?></td>
	<td>P <?php echo CHtml::encode(number_format($package->amount, 2)); ?> <b>|</b> <?php echo CHtml::encode($package->interest_rate); ?>% <b>|</b> <?php echo CHtml::encode($package->months_payable); ?> mos.</td>
	<td><?php echo CHtml::encode(date('M. d, Y', strtotime($data->date_created))); ?></td>
	<td>
		<?php
			switch ($data->status) {
				case 'I':
					echo "<label class='label label-info'>Invitation</label>";
					break;
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
            	<?php echo CHtml::link('<span class="fa fa-search"></span> View Profile', 'javascript:void(0);', array('class'=>'view-account', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'data-url'=>Yii::app()->createUrl('admin/account/view', array('id'=>$data->account_id)))); ?>
            </li>
            <?php if ($data->status != "I"): ?>
            	<li class="divider"></li>
	            <li>
		            <?php
						switch ($data->status) {
							case 'P':
								echo CHtml::link('<span class="fa fa-check"></span> Approve', array('loan/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to approve this application?', 'title'=>'Approve Investment'));
								echo CHtml::link('<span class="fa fa-times"></span> Reject', array('loan/reject', 'id'=>$data->id), array('confirm'=>'Are you sure you want to reject this application?', 'title'=>'Reject Investment'));
								break;
							case 'A':
								echo CHtml::link('<span class="fa fa-times"></span> Reject', array('loan/reject', 'id'=>$data->id), array('confirm'=>'Are you sure you want to reject this application?', 'title'=>'Reject Investment'));
								break;
							case 'R':
								echo CHtml::link('<span class="fa fa-check"></span> Approve', array('loan/approve', 'id'=>$data->id), array('confirm'=>'Are you sure you want to approve this application?', 'title'=>'Approve Investment'));
								break;
						}
					?>
	            </li>
            <?php endif ?>
          </ul>
    	</div>
	</td>
</tr>