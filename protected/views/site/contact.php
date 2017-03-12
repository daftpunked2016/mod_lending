<section class="innercontent">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="heading">Contact Us</h2>
				<div class="row">
					<div class="col-md-8 col-lg-8">
						<?php 
							foreach(Yii::app()->user->getFlashes() as $key=>$message) {
								if($key  === 'success') {
									echo "<div class='alert alert-success alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
									$message.'</div>';
								} else {
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
									$message.'</div>';
								}
							}
						?>
						<div class="panel panel-default x-panel">
							<div class="panel-body">
								<div class="reg-form box">
									<div id="message"></div>
									<?php 
										$form = $this->beginWidget('CActiveForm', array(
											'id'=>'inquiry-form',
											// 'enableClientValidation'=>true,
											// 'clientOptions'=>array(
											// 	'validateOnSubmit'=>true,
											// ),
										));
									?>
									<!-- <form method="post" action="#" id="contact-form"> -->
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<!-- <input type="text" class="form-control" name="yourname" id="yourname" placeholder="Your Name"> -->
													<?php echo $form->textField($inquiry,'name', array('class'=>'form-control', 'placeholder'=>'Name')); ?>
													<?php echo $form->error($inquiry,'name', array('style'=>'color: red;')); ?>
												</div>
											</div>
											<!-- <div class="col-md-6">
												<div class="form-group">
													<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
												</div>
											</div> -->
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<!-- <input type="email" class="form-control" name="email" id="youremail" placeholder="Your Email"> -->
													<?php echo $form->textField($inquiry,'email', array('class'=>'form-control', 'placeholder'=>'Email')); ?>
													<?php echo $form->error($inquiry,'email', array('style'=>'color: red;')); ?>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<!-- <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone"> -->
													<?php echo $form->textField($inquiry,'contact_number', array('class'=>'form-control', 'placeholder'=>'Phone')); ?>
													<?php echo $form->error($inquiry,'contact_number', array('style'=>'color: red;')); ?>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<!-- <textarea class="form-control" rows="3" name="message" placeholder="Your Message"></textarea> -->
													<?php echo $form->textArea($inquiry,'message',array('class'=>'form-control', 'rows'=>3, 'placeholder'=>'Message', 'style'=>'resize: none;')); ?>
													<?php echo $form->error($inquiry,'message', array('style'=>'color: red;')); ?>
												</div>
											</div>
											<div class="col-md-12">
												<?php if(CCaptcha::checkRequirements()): ?>
												<div class="form-group">
													<?php echo $form->labelEx($inquiry,'verifyCode'); ?>
													<div>
														<?php $this->widget('CCaptcha'); ?>
														<?php echo $form->textField($inquiry,'verifyCode'); ?>
													</div>
													<div class="hint">Please enter the letters as they are shown in the image above.
													<br/>Letters are not case-sensitive.</div>
													<?php echo $form->error($inquiry,'verifyCode', array('style'=>'color: red;')); ?>
												</div>
												<?php endif; ?>
											</div>
										</div>

										<?php echo CHtml::submitButton('SEND MESSAGE', array('class'=>'btn btn-default')); ?>
									<!-- </form> -->
									<?php $this->endWidget(); ?>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<aside class="col-md-4 col-lg-4">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="panel panel-default theme-panel">
									<div class="panel-heading">Address Information</div>
									<div class="panel-body">
										<ul class="list-unstyled address-list">
											<li><i class="fa fa-phone fa-fw"></i> 48800 Chakwal, Punjab, Pakistan</li>
											<li><i class="fa fa-mobile fa-fw"></i> +92 332 590 3076</li>
											<li><i class="fa fa-at fa-fw"></i> <a href="#">info@example.net</a></li>
											<li><i class="fa fa-globe fa-fw"></i> <a href="#">www.mirchu.net</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="panel panel-default theme-panel">
									<div class="panel-heading">Follow Me</div>
									<div class="panel-body">
										<ul class="list-inline follow-me">
											<li><a class="facebook" target="_blank" href="#"><i class="fa fa-facebook"></i></a></li>
											<li><a class="twitter" target="_blank" href="#"><i class="fa fa-twitter"></i></a></li>
											<li><a class="google-plus" target="_blank" href="#"><i class="fa fa-google-plus"></i></a></li>
											<li><a class="behance" target="_blank" href="#"><i class="fa fa-behance"></i></a></li>
											<li><a class="tumblr" target="_blank" href="#"><i class="fa fa-tumblr"></i></a></li>
											<li><a class="pinterest" target="_blank" href="#"><i class="fa fa-pinterest"></i></a></li>
										</ul>
									</div>
								</div>
							</div> 
						</div>
					</aside>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- <section class="map">
	<div id="contact_map" class="wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.9s"></div>
</section> -->