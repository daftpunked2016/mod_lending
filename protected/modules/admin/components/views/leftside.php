<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
          <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="">
        <?php echo CHtml::link('<i class="fa fa-dashboard text-red"></i> <span>Dashboard</span>', array('default/index')); ?>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users text-red"></i> <span>User Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left text-red pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu menu-open" style="display: block;">
          <li class="" id="investor_tab_left_side">
            <a href="#">
              <i class="fa fa-user text-red"></i> Investor
              <span class="pull-right-container">
                <i class="fa fa-angle-left text-red pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="pending-accounts">
                <?php echo CHtml::link('<i class="fa fa-question text-red"></i> Pending', array('account/index', 'type'=>'I', 'status'=>'P')); ?>
              </li>
              <li class="approved-accounts">
                <?php echo CHtml::link('<i class="fa fa-user-plus text-red"></i> Approved', array('account/index', 'type'=>'I', 'status'=>'A')); ?>
              </li>
              <li class="disabled-accounts">
                <?php echo CHtml::link('<i class="fa fa-ban text-red"></i> Disabled', array('account/index', 'type'=>'I', 'status'=>'D')); ?>
              </li>
              <li class="rejected-accounts">
                <?php echo CHtml::link('<i class="fa fa-user-times text-red"></i> Rejected', array('account/index', 'type'=>'I', 'status'=>'R')); ?>
              </li>
            </ul>
          </li>
          <li class="" id="borrower_tab_left_side">
            <a href="#">
              <i class="fa fa-user text-red"></i> Borrower
              <span class="pull-right-container">
                <i class="fa fa-angle-left text-red pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="pending-accounts">
                <?php echo CHtml::link('<i class="fa fa-question text-red"></i> Pending', array('account/index', 'type'=>'B', 'status'=>'P')); ?>
              </li>
              <li class="approved-accounts">
                <?php echo CHtml::link('<i class="fa fa-user-plus text-red"></i> Approved', array('account/index', 'type'=>'B', 'status'=>'A')); ?>
              </li>
              <li class="disabled-accounts">
                <?php echo CHtml::link('<i class="fa fa-ban text-red"></i> Disabled', array('account/index', 'type'=>'B', 'status'=>'D')); ?>
              </li>
              <li class="rejected-accounts">
                <?php echo CHtml::link('<i class="fa fa-user-times text-red"></i> Rejected', array('account/index', 'type'=>'B', 'status'=>'R')); ?>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li id="content_management" class="">
        <?php echo CHtml::link('<i class="fa fa-file text-red"></i> <span>Content Management</span>', array('content/index')); ?>
      </li>
      <li id="package" class="">
        <?php echo CHtml::link('<i class="fa fa-folder-open text-red"></i> <span>Packages</span>', array('package/index')); ?>
      </li>
      <li id="mailbox" class="">
        <?php echo CHtml::link('<i class="fa fa-envelope text-red"></i> <span>Mailbox</span>', array('message/index', 'folder'=>'inbox')); ?>
      </li>
      <li id="loan">
        <?php echo CHtml::link('<i class="fa fa-list text-red"></i> <span>Loan Application</span>', array('loan/list')); ?>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>