<?php session_start();
//Define Root Path
define('ROOT_PATH', dirname(__FILE__));
$_SESSION['path'] = ROOT_PATH;

$base_path=$_SESSION['base_path'];
 define('base_path', $base_path);
                  
if(!isset($_SESSION['demo'])) {

	header("Location: login.php");
	exit();
}

require_once ROOT_PATH . '/language/language.php';
require_once ROOT_PATH . '/lib/model/admin/hospitalInfo.php';

$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];

date_default_timezone_set('Asia/Kolkata');
?>
<?php
	if(!isset($_GET['current_menu'])){
		$current_menu="Home";			
	}else $current_menu=$_GET['current_menu'];

        /*if(isset($_SESSION['current_menu']) && $_SESSION['current_menu'] == "Bill_Procedure") {
              $current_menu=$_SESSION['current_menu'];
        }*/
		
		?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="index.php" class="navbar-brand"><b><?php echo $clinic_name; ?></a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php?current_menu=Home"><i class="fa fa-user"></i> Home</a></li>
			<?php
			
			 if($_SESSION['user_type'] == "NURSE" || $_SESSION['user_type'] == "SUPER NURSE"){?>
			 
			     <li ><a href="index.php?current_menu=Nurse&sub_menu=in_patient_list"><i class="fa fa-user"></i>Inpatients</a></li>
				  <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">OP Billing<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                   <li><a href="index.php?current_menu=Billing&sub_menu=op_bill">OP Patient Bill</a></li>
				   <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Billing">Manage Billing</a></li>  
						 
                  </ul>
                </li>
			   
			 
			<?php }
			  if($_SESSION['user_type'] == "DOCTOR" ){?>
			 
			     <li ><a href="index.php?current_menu=OPPatients"><i class="fa fa-user"></i> OP Patients</a></li>
			     <li ><a href="index.php?current_menu=Patient_History"><i class="fa fa-user"></i>Patient History</a></li>
				 <li ><a href="index.php?current_menu=inpatients"><i class="fa fa-user"></i>Inpatients</a></li>
			 
			<?php }
			 if($_SESSION['user_type'] == "CASUALITY"){?>
			 
			    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">IN Patients<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=IP&sub_menu=OP_Search">Admit</a></li>
		    <li><a href="index.php?current_menu=IP&sub_menu=manageInpatient">Manage Inpatient</a></li>
					<li class="divider"></li>
                     <li><a href="index.php?current_menu=IP&sub_menu=Discharge">Discharge Inpatients</a></li> 
                     <li><a href="index.php?current_menu=IP&sub_menu=Discharged_patients">Discharged Patients</a></li> 		    
                    <li class="divider"></li>
                 
                  </ul>
                </li>
			      <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Billing<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
		   <li><a href="index.php?current_menu=Billing&sub_menu=customer_bill">Direct Customer Bill</a></li>
                   <li><a href="index.php?current_menu=Billing&sub_menu=op_bill">OP Patient Bill</a></li>
		   <li><a href="index.php?current_menu=Billing&sub_menu=ip_bill">IN Patient Bill</a></li>
					 <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Billing">Manage Billing</a></li>  
					<li class="divider"></li>
					
                
                     <li><a href="index.php?current_menu=Report&sub_menu=bill_report">Bill Report</a></li>   					
                    	
                  </ul>
                </li>
			 <?php } 
			 if($_SESSION['user_type'] == "XRAY"){?>
			 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Procedures<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
					<li><a href="index.php?current_menu=Procedures&sub_menu=Manage_Category">Manage Category</a></li>
					<li class="divider"></li>
                   
                    <li><a href="index.php?current_menu=Procedures&sub_menu=Manage_Procedure">Manage Procedure</a></li>   					
                    <li class="divider"></li>
                 
                  </ul>
                </li>
			 
			     <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Billing<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
		   <li><a href="index.php?current_menu=Billing&sub_menu=customer_bill">Direct Customer Bill</a></li>
                   <li><a href="index.php?current_menu=Billing&sub_menu=op_bill">OP Patient Bill</a></li>
		   <li><a href="index.php?current_menu=Billing&sub_menu=ip_bill">IN Patient Bill</a></li>
					 <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Billing">Manage Billing</a></li>  
					<li class="divider"></li>
					
                
                     <li><a href="index.php?current_menu=Report&sub_menu=bill_report">Bill Report</a></li>   					
                    	
                  </ul>
                </li>
			 <?php }
			
			
			if($_SESSION['user_type'] == "ADMIN+DOCTOR"){?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Doctor<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li ><a href="index.php?current_menu=OPPatients"><i class="fa fa-user"></i> OP Patients</a></li>
			        <li ><a href="index.php?current_menu=Patient_History"><i class="fa fa-user"></i>Patient History</a></li>
				    <li ><a href="index.php?current_menu=inpatients"><i class="fa fa-user"></i>Inpatients</a></li>
                 
                  </ul>
                </li>
			<?php } 
			  if($_SESSION['user_type'] == "ADMIN" || $_SESSION['user_type'] == "ADMIN+DOCTOR"){?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin  <i class="fa fa-envelope-o"></i><span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=Admin&sub_menu=HospitalInfo">Hospital Info</a></li>
					<li><a href="index.php?current_menu=Admin&sub_menu=Department">Departments</a></li>
					<li class="divider"></li>
                    <li><a href="index.php?current_menu=Admin&sub_menu=Designation">Job Designation</a></li>   
                    <li><a href="index.php?current_menu=Admin&sub_menu=User">Users</a></li>   					
                    <li class="divider"></li>
					<li><a href="index.php?current_menu=Admin&sub_menu=Speciality">Speciality</a></li>   
                    <li><a href="index.php?current_menu=Admin&sub_menu=OPSettings">OP Settings</a></li>   					
                    <li class="divider"></li>
					<li><a href="index.php?current_menu=Admin&sub_menu=Employee">Employees</a></li>   
                    <li><a href="index.php?current_menu=Admin&sub_menu=Insurance">Insurance Company</a></li>   					
                    <li class="divider"></li>
                 
                  </ul>
                </li>
			<?php } ?>
			
		 <?php
			
			if($_SESSION['user_type'] == "ADMIN"  || $_SESSION['user_type'] == "ADMIN+DOCTOR"|| $_SESSION['user_type'] == "RECEPTION"){?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">OP Patients<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=Registration&sub_menu=patient_registeration">Registeration</a></li>
					<li><a href="index.php?current_menu=Registration&sub_menu=patient_re_registeration">Re Registeration</a></li>
					<li class="divider"></li>
                    <li><a href="index.php?current_menu=Registration&sub_menu=ManagePatients">Manage Registeration</a></li>
                    <li><a href="index.php?current_menu=Registration&sub_menu=Patient_Records">Patient Records</a></li>                      
                    <li class="divider"></li>
                 
                  </ul>
                </li>
		<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">IN Patients<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=IP&sub_menu=OP_Search">Admit</a></li>
		    <li><a href="index.php?current_menu=IP&sub_menu=manageInpatient">Manage Inpatient</a></li>
					<li class="divider"></li>
                     <li><a href="index.php?current_menu=IP&sub_menu=Discharge">Discharge Inpatients</a></li> 
                     <li><a href="index.php?current_menu=IP&sub_menu=Discharged_patients">Discharged Patients</a></li> 		    
                    <li class="divider"></li>
                 
                  </ul>
                </li>
		<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Booking<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=Booking&sub_menu=Booking">Booking</a></li>
					<li><a href="index.php?current_menu=Booking&sub_menu=Booking_Report">Booking Report</a></li>
					<li class="divider"></li>
                    <li><a href="index.php?current_menu=Booking&sub_menu=Manage_Scheduling">Scheduling</a></li> 
                    <li><a href="index.php?current_menu=Booking&sub_menu=Token_Reservation">Token Reservation</a></li> 					
                    <li class="divider"></li>
                 
                  </ul>
                </li>
		<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Room<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="index.php?current_menu=Room&sub_menu=RoomCategory">Room Category</a></li>
		    <li><a href="index.php?current_menu=Room&sub_menu=Room">Manage Rooms</a></li>
		    <li><a href="index.php?current_menu=Room&sub_menu=RoomStatus">Room Status</a></li> 
                    <li><a href="index.php?current_menu=Room&sub_menu=Nursing_Stations">Nursing Stations</a></li> 					
                    <li class="divider"></li>
                 
                  </ul>
                </li>
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Procedures<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
					<li><a href="index.php?current_menu=Procedures&sub_menu=Manage_Category">Manage Category</a></li>
					<li class="divider"></li>
                   
                    <li><a href="index.php?current_menu=Procedures&sub_menu=Manage_Procedure">Manage Procedure</a></li>   					
                    <li class="divider"></li>
                 
                  </ul>
                </li>
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Billing<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                  
		   <li><a href="index.php?current_menu=Billing&sub_menu=customer_bill">Direct Customer Bill</a></li>
                   <li><a href="index.php?current_menu=Billing&sub_menu=op_bill">OP Patient Bill</a></li>
		   <li><a href="index.php?current_menu=Billing&sub_menu=ip_bill">IN Patient Bill</a></li>
					 <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Billing">Manage Billing</a></li>  
					<li class="divider"></li>
					
                
                     <li><a href="index.php?current_menu=Billing&sub_menu=Credit_Billing">Credit Billing</a></li> 
                      <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Credit_Billing">Manage Credit Billing</a></li> 					 
                    <li class="divider"></li>
                     <li><a href="index.php?current_menu=Billing&sub_menu=IP_Search">IP Payments</a></li>   	
		     <li><a href="index.php?current_menu=Billing&sub_menu=Manage_IP_Payments">Manage IP Payments</a></li>
		     <li><a href="index.php?current_menu=Billing&sub_menu=Manage_IP_Credits">Manage IP Credits</a></li>
                     <li><a href="index.php?current_menu=Billing&sub_menu=Manage_IP_Credit_Payments">Manage IP Credit Payments</a></li>		     
                     <li><a href="index.php?current_menu=Billing&sub_menu=Manage_Advance_Payments">Manage Advance Payments</a></li> 					 
                  </ul>
                </li>
		
	 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
	 <ul class="dropdown-menu" role="menu">
                   <li><a href="index.php?current_menu=Report&sub_menu=daily_collection">Daily Collection Report</a></li>
                   <li><a href="index.php?current_menu=Report&sub_menu=bill_collection">Daily Bill Collection Report</a></li>
				   <li><a href="index.php?current_menu=Report&sub_menu=bill_collection_all_user">Bill Collection Report(All User)</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=doctor_consolidated">Doctors Report</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=doctor_procedure_report">Doctors Procedure Report</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=patient_report">OP Patient Report</a></li> 
           <li><a href="index.php?current_menu=Report&sub_menu=op_card_issued">OP Card Issued Report</a></li> 		   
		   <li><a href="index.php?current_menu=Report&sub_menu=age_gender_report">Agewise Patient Report</a></li>
		    <li><a href="index.php?current_menu=Report&sub_menu=cancelled_op">OP Cancellation Report</a></li>
                   <li><a href="index.php?current_menu=Report&sub_menu=bill_report">Bill Report</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=bill_report_item_details">Bill Report [Item Deltails]</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=itemwise_bill_report">Itemwise Bill Report</a></li> 
		   <li><a href="index.php?current_menu=Report&sub_menu=itemwise_conso_bill_report">Itemwise Consolidated Bill Report</a></li>  
		   <li><a href="index.php?current_menu=Report&sub_menu=credit_payment">Credit Payment Report</a></li>
		   <li><a href="index.php?current_menu=Report&sub_menu=ip_credit_report">IP Credit Report</a></li>
                   
                 
                  </ul>
                </li>
	<?php } ?>
              </ul>
             
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
				
				 <!--<li class="dropdown messages-menu">
               
                <a href="<?php echo base_path;?>index.php" >
                  <i><?php echo date('F d, Y h:i a') ?></i>
                  
                </a>
                
              </li>-->
                                  
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php echo $_SESSION['user_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <!--<li class="user-header">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <p>
                          <?php echo $_SESSION['user_name']; ?>
                         
                        </p>
                      </li>-->
                     
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
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
         <?php
	  	if ($_SESSION['user_type'] == "DOCTOR" && $current_menu=="Home"){?>
                
                  <iframe src="home.php" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if (($_SESSION['user_type'] == "DOCTOR" || $_SESSION['user_type'] == "ADMIN+DOCTOR") && $current_menu=="OPPatients"){?>
                
                  <iframe src="lib/controllers/centralController.php?module=Doctor&sub_module=OPPatient_list&View=View" width="100%" height="700" frameborder="0"  ></iframe>

                <?php }else if (($_SESSION['user_type'] == "DOCTOR" || $_SESSION['user_type'] == "ADMIN+DOCTOR") && $current_menu=="Patient_History"){?>
                
                  <iframe src="lib/controllers/centralController.php?module=Doctor&sub_module=patient_history&View=View" width="100%" height="700" frameborder="0"  ></iframe>


                <?php }else if (($_SESSION['user_type'] == "DOCTOR" || $_SESSION['user_type'] == "ADMIN+DOCTOR") && $current_menu=="inpatients"){?>
                
                  <iframe src="lib/controllers/centralController.php?module=Doctor&sub_module=inpatients&View=View" width="100%" height="700" frameborder="0"  ></iframe>


                <?php }else if($current_menu=="Home"){ ?>
		
     		 <iframe src="home.php" width="1230" height="600" frameborder="0"  ></iframe>
			 
		<?php }else if ($_SESSION['user_type'] == "NURSE" || $_SESSION['user_type'] == "SUPER NURSE" && $current_menu!="Billing"){  ?>
                
                  <iframe src="lib/controllers/centralController.php?module=Nurse&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Home'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>

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
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'Select_Bill'?>" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php }else if ($current_menu=="Report"){?>
		
			<iframe src="lib/controllers/centralController.php?module=<?php echo $current_menu;?>&sub_module=<?php echo isset($_GET['sub_menu']) ? $_GET['sub_menu'] : 'index'?>&View=View" width="100%" height="700" frameborder="0"  ></iframe>
			
		<?php } ?>
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
          </div>
          <strong>Copyright &copy; 2016 <a href="http://uniziontechnologies.com">Unizion Technologies</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
  </body>
</html>
