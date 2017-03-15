<!-- start home -->
<section id="home">
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
					<h1 class="text-upper">Software Landing Page</h1>
					<p class="tm-white">Boxer is a fully Responsive, Clean Design, Modern, and Flexible Software Landing Page for startups, businesses and agencies. It is built with HTML5 &amp; CSS3, Bootstrap 3.3.4, Font Awesome 4.3.0, and much more. Designed by <a rel="nofollow" href="http://www.facebook.com/templatemo" target="_parent">templatemo</a>. Images by <a rel="nofollow" href="http://pixabay.com" target="_blank">Pixabay</a></p>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/landingpage_assets/images/software-img.png" class="img-responsive" alt="home img">
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
				<h2 class="text-uppercase">Our Software Features</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p><span><i class="fa fa-mobile"></i></span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p><i class="fa fa-code"></i>Quis autem velis reprehenderit et quis voluptate velit esse quam.</p>
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
				<h2 class="text-uppercase">More of Your Software</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p><span><i class="fa fa-mobile"></i></span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p><i class="fa fa-code"></i>Quis autem velis reprehenderit et quis voluptate velit esse quam.</p>
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
							<h4>Package <?php echo $data->id; ?></h4>
							<p>P <?php echo number_format($data->amount, 2); ?></p>
							<!-- <small class="text-lowercase">monthly</small> -->
						</div>
						<ul>
							<li><?php echo $data->interest_rate; ?>% Interest rate</li>
							<li><?php echo $data->months_payable; ?> Months to pay</li>
							<!-- <li>60 More Themes</li> -->
							<!-- <li>Lifetime Support</li> -->
						</ul>
						<?php echo CHtml::link('Sign up', array('site/register'), array('class'=>'btn btn-primary text-uppercase')) ?>
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
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
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
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation. </p>
					<address>
						<p><i class="fa fa-map-marker"></i>36 Street Name, City Name, United States</p>
						<p><i class="fa fa-phone"></i> 010-010-0110 or 020-020-0220</p>
						<p><i class="fa fa-envelope-o"></i> info@company.com</p>
					</address>
				</div>
				<div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
					<div class="contact-form">
						<form action="#" method="post">
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Name">
							</div>
							<div class="col-md-6">
								<input type="email" class="form-control" placeholder="Email">
							</div>
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Subject">
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