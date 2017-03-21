<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>CR</b>C</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>ChanRobles</b>Capital</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/admin-icon.png" class="user-image" alt="User Image"/>
            <span class="hidden-xs">
              <?php echo $user->first_name." ".$user->last_name; ?>
            </span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/admin-icon.png" class="img-circle" alt="User Image" />
              <p>
                <strong><?php echo $user->first_name." ".$user->last_name; ?></strong>
                <small>ADMIN</small>
              </p>
            </li>
            <!-- Menu Body -->
            <!-- <li class="user-body">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <?php echo CHtml::link('Profile', array('account/settings'), array('class'=>'btn btn-default btn-flat')); ?>
              </div>
              <div class="pull-right">
                <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                <?php echo CHtml::link('Sign Out', array('default/logout'),array('class'=>'btn btn-default btn-flat')); ?>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <!-- <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li> -->
      </ul>
    </div>
  </nav>
</header>