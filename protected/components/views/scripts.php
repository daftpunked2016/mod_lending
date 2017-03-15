<script src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/js/jquery.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/js/wow.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/js/jquery.singlePageNav.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/js/custom.js"></script>

<!-- CUSTOM SCRIPTS ON LANDING PAGE -->
<script type="text/javascript">
$(function() {
	$('#login').click(function() {
        window.location = "<?php echo Yii::app()->createUrl('site/login'); ?>";
    });

    $('#business_name').click(function() {
        window.location = "<?php echo Yii::app()->createUrl('site/index'); ?>";
    });
});
</script>