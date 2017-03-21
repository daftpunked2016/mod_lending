<tr>
	<td>
		<strong>
			<?php echo CHtml::encode($data->account->user->id_name); ?>
		</strong>
	</td>
	<td><?php echo CHtml::encode($data->package_id); ?></td>
	<td><?php echo CHtml::encode($data->package->interest_rate); ?>%</td>
	<td><?php echo CHtml::encode($data->package->months_payable); ?> mos.</td>
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
            	<?php echo CHtml::link('<span class="fa fa-search"></span> Documents', 'javascript:void(0);', array('class'=>'view-account', 'data-toggle'=>'modal', 'data-target'=>'.bs-example-modal-lg', 'data-url'=>Yii::app()->createUrl('admin/account/view', array('id'=>$data->account_id)))); ?>
            </li>
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
          </ul>
    	</div>
	</td>
</tr>