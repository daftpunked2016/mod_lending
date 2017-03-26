<tr>
	<td><?php echo CHtml::encode($data->description); ?></td>
	<td><?php echo CHtml::encode($data->content); ?></td>
	<!-- <td>
		<?php
			// switch ($data->status) {
			// 	case 'A':
			// 		echo "<label class='label label-success'>Active</label>";
			// 		break;

			// 	case 'D':
			// 		echo "<label class='label label-danger'>Disabled</label>";
			// 		break;
			// }
		?>
	</td> -->
	<td class="text-center">
		<?php echo CHtml::link('<span class="fa fa-edit"></span> Edit', array('content/edit', 'id'=>$data->id), array('title'=>'Edit Content', 'class'=>'btn-sm btn-success')); ?>
	</td>
	<!-- <td>
		<div class="btn-group">
          <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="fa fa-cog"></span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
            	<?php //echo CHtml::link('<span class="fa fa-search"></span> View'); ?>
            </li>
            <li>
            	<?php //echo CHtml::link('<span class="fa fa-edit"></span> Edit', array('content/edit', 'id'=>$data->id), array('title'=>'Edit Account')); ?>
            </li>
            <li class="divider"></li>
            <li>
	            <?php
		            // switch ($data->status) {
		            // 	case 'A':
		            // 		echo CHtml::link('<i class="fa fa-times"></i> Disable', array('content/disable', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Disable this content?', 'title'=>'Disable Content'));
		            // 		break;
		            // 	case 'D':
		            // 		echo CHtml::link('<i class="fa fa-check"></i> Activate', array('content/activate', 'id'=>$data->id), array('confirm'=>'Are you sure you want to Activate this content?', 'title'=>'Activate Content'));
		            // 		break;
		            // }
	            ?>
            </li>
          </ul>
    	</div>
	</td> -->
</tr>