<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datepicker/datepicker3.css">

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'approve-form',
)); ?>
<div class="modal-header label-danger">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="gridSystemModalLabel">
		<strong>Approve Loan Request</strong>
	</h4>
</div>
<div class="modal-body">
	<div class="form-group">
		<?php echo $form->labelEx($loan, 'date_started'); ?>
		<?php echo $form->textField($loan, 'date_started', array('class'=>'form-control', 'placeholder'=>'Year-Month-Day eg. (2017-01-31)', 'required'=>'required')) ?>
		<?php echo $form->error($loan,'date_started'); ?>
	</div>
</div>
<div class="modal-footer">
	<div class="pull-left">
		<?php echo CHtml::link('Close', 'javascript:void(0);', array('data-dismiss'=>'modal', 'class'=>'btn btn-danger btn-flat')); ?>
	</div>
	<div class="pull-right">
		<?php echo CHtml::submitButton($loan->isNewRecord ? 'Apply' : 'Approve', array('class'=>'btn btn-danger btn-block btn-flat', 'confirm'=>'Are you sure you want to Approve this Request?', 'id'=>'approve-request')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

<!-- bootstrap datepicker -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(function() {
	//Date picker
    $('#Loan_date_started').datepicker({
    	format: 'yyyy-mm-dd',
    	autoclose: true
    });

	$('#approve-request').click(function() {
		var date_started = $('#Loan_date_started').val();

		if (date_started != '') {
			$(this).removeClass('btn-danger').addClass('btn-warning disabled').val('Processing')
		}
	});
});
</script>