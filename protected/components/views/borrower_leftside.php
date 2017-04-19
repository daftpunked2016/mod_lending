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
      <li class="header">BORROWER NAVIGATION</li>
      <li id="dashboard" class="">
        <?php echo CHtml::link('<i class="fa fa-dashboard text-red"></i> <span>Dashboard</span>', array('account/dashboard')); ?>
      </li>
      <li id="mailbox" class="">
        <?php echo CHtml::link('<i class="fa fa-envelope text-red"></i> <span>Mailbox</span>', array('message/index', 'folder'=>'inbox')); ?>
      </li>
      <li id="investment" class="">
        <?php echo CHtml::link('<i class="fa fa-share text-red"></i> <span>Investments</span>', array('loan/investments')); ?>
      </li>
      <li id="loans" class="">
        <?php echo CHtml::link('<i class="fa fa-sign-in text-red"></i> <span>Loans</span>', array('loan/index')); ?>
      </li>
      <li id="open_loans" class="">
        <?php echo CHtml::link('<i class="fa fa-sign-out text-red"></i> <span>Loan Requests</span>', array('loan/open')); ?>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>