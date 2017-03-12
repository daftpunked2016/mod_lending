<!DOCTYPE html>
<html lang="en">
	<?php $this->widget('Head'); ?>
	<body>
		<!-- start preloader -->
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div>
		<!-- end preloader -->

		<!-- start Header -->
		<?php $this->widget('Header'); ?>
		<!-- end Header -->

		<!-- start Content -->
		<?php echo $content; ?>
		<!-- end Content -->

		<!-- start footer -->
		<?php $this->widget('Footer'); ?>
		<!-- end footer -->
        
        <!-- start Scripts -->
		<?php $this->widget('Scripts'); ?>
        <!-- end Scripts -->
	</body>
</html>