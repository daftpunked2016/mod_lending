<!-- start home -->
<section id="home">
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
					<h1 class="text-upper"><?php echo Yii::app()->name; ?></h1>
					<p class="tm-white">
						<?php
							$home_data = Content::model()->find(array('condition'=>'description = "home"'));

							echo $home_data->content;
						?>
					</p>
					<!-- <img src="<?php //echo Yii::app()->request->baseUrl; ?>/landingpage_assets/images/software-img.png" class="img-responsive" alt="home img"> -->
					<div class="row" style="padding-top: 50px;">
						<div class="col-md-4 col-sm-4 wow fadeIn" data-wow-delay="0.3s">
							<?php echo CHtml::link('<strong>Want to Borrow?</strong>', array('site/investments'), array('class'=>'btn btn-danger btn-block text-uppercase', 'style'=>'border-radius: 0px; border: 1px solid transparent; margin-bottom: 15px;')); ?>
						</div>
						<div class="col-md-4 col-sm-4 wow fadeIn" data-wow-delay="0.3s">
							<?php echo CHtml::link('<strong>Want to Invest?</strong>', '#pricing', array('class'=>'btn btn-warning btn-block text-uppercase', 'style'=>'border-radius: 0px; border: 1px solid transparent; margin-bottom: 15px;')); ?>						
						</div>
						<div class="col-md-4 col-sm-4 wow fadeIn" data-wow-delay="0.3s">
							<?php echo CHtml::link('<strong>Existing user?</strong>', array('site/login'), array('class'=>'btn btn-info btn-block text-uppercase', 'style'=>'border-radius: 0px; border: 1px solid transparent; margin-bottom: 15px;')); ?>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
		</div>
	</div>
</section>
<!-- end home -->

<!-- start divider -->
<!-- <section id="divider">
	<div class="container">
		<div class="row">
			<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
				<i class="fa fa-laptop"></i>
				<h3 class="text-uppercase">RESPONSIVE LAYOUT</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
			</div>
			<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
				<i class="fa fa-twitter"></i>
				<h3 class="text-uppercase">BOOTSTRAP 3.3.4</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
			</div>
			<div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
				<i class="fa fa-font"></i>
				<h3 class="text-uppercase">GOOGLE FONT</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
			</div>
		</div>
	</div>
</section> -->
<!-- end divider -->

<!-- start feature -->
<section id="feature">
	<div class="container">
		<div class="row">
			<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
				<h2 class="text-uppercase">Services</h2>
				<p>
					<?php
						$services_data = Content::model()->find(array('condition'=>'description = "services"'));

						echo $services_data->content;
					?>
				</p>
				<br></br>
				<p><i class="fa fa-briefcase"></i> <?php echo CHtml::link('Invest', array('site/register', 'type'=>'I')); ?></p>
				<p><i class="fa fa-user"></i> <?php echo CHtml::link('Apply Loan', '#pricing'); ?></p>
			</div>
			<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/images/software-img.png" class="img-responsive" alt="feature img">
			</div>
		</div>
	</div>
</section>
<!-- end feature -->

<!-- start feature1 -->
<section id="feature1">
	<div class="container">
		<div class="row">
			<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/images/software-img.png" class="img-responsive" alt="feature img">
			</div>
			<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
				<h2 class="text-uppercase">Manage your Account</h2>
				<p>
					<?php
						$manage_account_data = Content::model()->find(array('condition'=>'description = "manage_account"'));

						echo $manage_account_data->content;
					?>
				</p>
				<p><i class="fa fa-sign-in"></i> <?php echo CHtml::link('Login your account here!', array('site/login')); ?> </p>
				<!-- <p><i class="fa fa-code"></i>Quis autem velis reprehenderit et quis voluptate velit esse quam.</p> -->
			</div>
		</div>
	</div>
</section>
<!-- end feature1 -->

<!-- start pricing -->
<section id="pricing">
	<div class="container">
		<div class="row">
			<div class="col-md-12 wow bounceIn">
				<h2 class="text-uppercase">Our Packages</h2>
			</div>
			<?php foreach ($packages as $data): ?>
				<div class="col-md-4 wow fadeIn" data-wow-delay="0.6s">
					<div class="pricing <?php if ($data->id == 2): ?>active<?php endif; ?> text-uppercase">
						<div class="pricing-title">
							<h4><?php echo $data->package_name; ?></h4>
							<p>P <?php echo number_format($data->amount, 2); ?></p>
							<!-- <small class="text-lowercase">monthly</small> -->
						</div>
						<ul>
							<li>
								<?php $rate = $data->interest_rate; ?>

								<?php echo $rate; ?>% Interest rate
							</li>
							<li><?php echo $data->months_payable; ?> Months to pay</li>
							<!-- <li>60 More Themes</li> -->
							<!-- <li>Lifetime Support</li> -->
						</ul>
						<?php echo CHtml::link('Apply Loan', array('site/login'), array('class'=>'btn btn-primary text-uppercase')) ?>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>
<!-- end pricing -->

<!-- start download -->
<section id="download">
	<div class="container">
		<div class="row">
			<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
				<h2 class="text-uppercase">Download Our Software</h2>
				<p>
					<?php
						$download_data = Content::model()->find(array('condition'=>'description = "download"'));

						echo $download_data->content;
					?>
				</p>
				<button class="btn btn-primary text-uppercase"><i class="fa fa-download"></i> Download</button>
			</div>
			<div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/images/software-img.png" class="img-responsive" alt="feature img">
			</div>
		</div>
	</div>
</section>
<!-- end download -->

<!-- start contact -->
<section id="contact">
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
					<h2 class="text-uppercase">Contact Us</h2>
					<p>
						<?php
							$contact_data = Content::model()->find(array('condition'=>'description = "contact"'));

							echo $contact_data->content;
						?>
					</p>
					<address>
						<p><i class="fa fa-map-marker"></i> <?php $address_data = Content::model()->find(array('condition'=>'description = "address"')); echo $address_data->content; ?></p>
						<p><i class="fa fa-phone"></i> <?php $phone_data = Content::model()->find(array('condition'=>'description = "company_phone"')); echo $phone_data->content; ?></p>
						<p><i class="fa fa-envelope-o"></i> <?php $address_data = Content::model()->find(array('condition'=>'description = "company_email"')); echo $address_data->content; ?></p>
					</address>
				</div>
				<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
					<div class="contact-form">
						<form action="#" method="post">
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Name">
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Contact Number">
							</div>
							<div class="col-md-12">
								<input type="email" class="form-control" placeholder="Email">
							</div>
							<div class="col-md-12">
								<textarea class="form-control" placeholder="Message" rows="4"></textarea>
							</div>
							<div class="col-md-8">
								<input type="submit" class="form-control text-uppercase" value="Send">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end contact -->