<section class="content-header">
	<h1>
		<strong>
			<?php echo CHtml::link(Yii::app()->name, array('site/index'), array('class'=>'text-red')); ?>
		</strong>
		<small>investments</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Home', array('site/index')); ?>
		</li>
		<li>
			<?php echo CHtml::link('Login', array('site/login')); ?>
		</li>
		<li class="active">Investments</li>
	</ol>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-body">
			<?php  
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$investmentsDP,
					'itemView'=>'_view_investments',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>AMOUNT</th>
							<th>INTEREST RATE</th>
							<th>MONTHS PAYABLE</th>
							<th class='text-center' width='15%'>Actions</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td class='text-center' colspan=\"4\">No available entries</td></tr>",
				));
			?>
		</div>
	</div>
</section>

<!-- Large modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" id="modal-content">
    	<!-- start content here -->
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
	$('.apply-loan').click(function() {
		var url = $(this).data('url');

		$.ajax({
			url: url,
			beforeSend: function() {
				$("#modal-content").html("Loading...");
			},
			success: function(response) {
				$("#modal-content").html(response);
			}
		})
	});
});
</script>