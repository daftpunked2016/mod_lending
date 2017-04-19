<section class="content-header">
	<h1>
		Loan Requests
		<small>list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Loan Requests', array('loan/open')); ?>
		</li>
		<li class="active">List</li>
	</ol>
	<br>
	<?php 
		foreach(Yii::app()->user->getFlashes() as $key=>$message) {
			if($key === 'success') {
				echo '<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Success!</h4>
				    '.$message.'</div>';
			} else {
				echo '<div class="alert alert-danger alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-ban"></i> Error!</h4>
				    '.$message.'</div>';
			}
		}
	?>
</section>

<section class="content">
	<?php echo CHtml::link('<span class="fa fa-sign-out"></span> Post Loan Request', "javascript:void(0);", array('class'=>'btn btn-danger btn-flat pull-right', 'data-toggle'=>'modal', 'data-target'=>'.open_form')); ?>
	<br></br>
	<br>
	<div class="box box-solid">
		<div class="box-body">
			<?php  
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$open_requestDP,
					'itemView'=>'_view_open_requests',
					'template' => "{sorter}
					<table id=\"example1\" class=\"table table-bordered table-hover\">
						<thead class='panel-heading'>
							<th>AMOUNT</th>
							<th>INTEREST RATE</th>
							<th>MONTHS PAYABLE</th>
							<th>INVITATION STATUS</th>
							<th>STATUS</th>
							<th class='text-center' width='15%'>Actions</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td class='text-center' colspan=\"6\">No available entries</td></tr>",
				));
			?>
		</div>
	</div>
</section>

<!-- Large modal -->
<div id="view-modal" class="modal fade bs-example-modal-lg open_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    	
    	<?php 
          $form=$this->beginWidget('CActiveForm', array(
            'id'=>'package-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
          ));
        ?>
    	<div class="modal-header label-danger">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel">
				<strong>Custom Package</strong>
			</h4>
		</div>
		<div class="modal-body">
			<div class="text-center">
				<p class="note">Fields with <span class="required">*</span> are required.</p>
			</div>
			
			<div class="form-group">
				<?php echo $form->labelEx($package, 'amount'); ?>
				<?php echo $form->numberField($package,'amount',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Amount')); ?>
				<?php echo $form->error($package,'amount', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($package, 'interest_rate'); ?>
				<?php echo $form->textField($package,'interest_rate',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Interest Rate (%)')); ?>
				<?php echo $form->error($package,'interest_rate', array('style'=>'color: red;')); ?>
			</div>

			<div class="form-group">
				<?php echo $form->labelEx($package, 'months_payable'); ?>
				<?php echo $form->numberField($package,'months_payable',array('size'=>128,'maxlength'=>128, 'class'=>'form-control', 'placeholder'=>'Months Payable')); ?>
				<?php echo $form->error($package,'months_payable', array('style'=>'color: red;')); ?>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-left">
				<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
			</div>
			<div class="pull-right">
				<?php echo CHtml::submitButton($package->isNewRecord ? 'Post Loan Request' : 'Save', array('class'=>'btn btn-danger btn-flat pull-right', 'id'=>'btn-submit', 'tabindex'=>4)); ?>
			</div>
		</div>

		<?php $this->endWidget(); ?>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
	$('#open_loans').addClass('active');

	$('.view-computation').click(function() {
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

	$('#btn-submit').click(function() {
		$(this).removeClass('btn-danger').addClass('btn-warning disabled').val('Processing');
	});
});
</script>