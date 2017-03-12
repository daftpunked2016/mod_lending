<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
        <span class="icon icon-bar"></span>
      </button>
      <a href="#home" class="navbar-brand">Boxer</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right text-uppercase">
        <li><a href="#home">Home</a></li>
        <li><a href="#feature">Features</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="#download">Download</a></li>
        <li><a href="#contact">Contact</a></li>
        <li id="login" data-target="<?php echo Yii::app()->createUrl('site/login'); ?>">
          <?php echo CHtml::link('Login', array('site/login')); ?>
        </li>
      </ul>
    </div>
  </div>
</nav>