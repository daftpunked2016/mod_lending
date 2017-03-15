<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
      </button>
      <!-- <a href="#home" class="navbar-brand">Chan Robles Capital</a> -->
      <?php echo CHtml::link('Chan Robles Capital', array('site/index'), array('class'=>'navbar-brand', 'id'=>'business_name')); ?>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right text-uppercase">
        <li><a href="#home">Home</a></li>
        <li><a href="#feature">Features</a></li>
        <li><a href="#pricing">Packages</a></li>
        <li><a href="#download">Download</a></li>
        <li><a href="#contact">Contact</a></li>
        <li id="login">
          <?php echo CHtml::link('Login', array('site/login')); ?>
        </li>
      </ul>
    </div>
  </div>
</nav>