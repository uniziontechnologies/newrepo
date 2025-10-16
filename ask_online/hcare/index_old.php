<?php include("main_header.php");?>
    
<?php
	if(!isset($_GET['current_menu'])){
		$current_menu="Home";			
	}else $current_menu=$_GET['current_menu'];

        if(isset($_SESSION['current_menu']) && $_SESSION['current_menu'] == "Bill_Procedure") {
              $current_menu=$_SESSION['current_menu'];
        }
?>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>HIMS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo $clinic_name; ?></b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
		  
            <ul class="nav navbar-nav">
			
			  <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="<?php echo base_path;?>index.php" >
                  <i><?php echo date('F d, Y h:i a') ?></i>
                  
                </a>
                
              </li>
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="<?php echo base_path;?>index.php" >
                  <i class="fa fa-home"></i>
                  
                </a>
                
              </li><!-- /.messages-menu -->

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo base_path;?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $_SESSION['user_name']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php echo base_path;?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
		  
           <li class="active"><a href="index.php?current_menu=Registration&sub_menu=patient_registeration"><i class="fa fa-user"></i> <span>Home</span></a></li>
            <li class="active"><a href="index.php?current_menu=Registration&sub_menu=patient_registeration"><i class="fa fa-user"></i> <span><?php echo  $lang_registration;?></span></a></li>
            <li><a href="index.php?current_menu=Registration&sub_menu=ManagePatients"><i class="fa fa-list"></i> <span><?php echo  $lang_patient_list;?></span></a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Link in level 2</a></li>
                <li><a href="#">Link in level 2</a></li>
              </ul>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
     

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
    
   
  <div class="content-wrapper">
  
  <?php
	  	if ($_SESSION['user_type'] == "DOCTOR" && $current_menu=="Home"){?>
                
                  <iframe src="medic/home.php" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if ($_SESSION['user_type'] == "DOCTOR" && $current_menu=="OPPatients"){?>
                
                  <iframe src="lib/controllers/centralController.php?module=Doctor&sub_module=OPPatient_list&View=View" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if ($_SESSION['user_type'] == "DOCTOR" && $current_menu=="Patient_History"){?>
                
                  <iframe src="medic/patient_history.php" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if ($_SESSION['user_type'] == "NURSE" ){  ?>
                
                  <iframe src="lib/controllers/centralController.php?module=Nurse&sub_module=<?php echo isset($current_menu) ? $current_menu : 'Home'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if($current_menu=="Home"){ ?>
		
     		 <iframe src="home.php" width="1230" height="600" frameborder="0"  ></iframe>
			 
		<?php }else if ($current_menu=="Admin"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'HospitalInfo'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Room"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Room'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Booking"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Booking'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php } else if ($current_menu=="Registration"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'patient_registeration'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="IP"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'OP_Search'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Procedures"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Manage_Procedure'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Billing"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Select_Bill'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Report"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'index'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php } ?>
  
  </div>
  
<!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
         
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#"> <a href="http://www.uniziontechnologies.com"><?php echo $lang_powerd_by;?> </a></a>.</strong> All rights reserved.
      </footer>
 <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_path;?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_path;?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_path;?>/dist/js/app.min.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
</html>
