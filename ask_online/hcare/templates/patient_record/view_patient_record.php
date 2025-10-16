<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
	   <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	   
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	<!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/iCheck/all.css">
		 <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
 <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="../../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
  
 <!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
    <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>


  <script>
 // $('.main-header', window.parent.document).hide();
  $(document).ready(function(){
	  
	  $(".side_menu").bind('click', function() {

        var active_module=$(this).attr("id");

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=View_Patient_Record&active_module="+active_module);
   	    $("#form").submit();


    });
	});
	function back_to_list() {

  	window.location=("../../lib/controllers/centralController.php?module=Registration&sub_module=Patient_Records");
  	$('.main-header', window.parent.document).show();
  	 
		


  }
  </script>

</head>

<?php

$patientInfo=$this  ->popArr['patient_info'];
$casesheetInfo=$this  ->popArr['casesheetInfo'];
$creditInfo=$this  ->popArr['creditInfo'];
$pharmaCreditInfo=$this  ->popArr['pharmaCreditInfo'];
$ipInfo=$this  ->popArr['ipInfo'];
$patient_id=$this  ->popArr['patient_id'];
$post=$this  ->popArr['postArr'];


$opcreditInfo=$this  ->popArr['opcreditInfo'];
//var_dump($opcreditInfo);
?>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

	<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="margin-top: -40px;">
          <!-- Sidebar user panel -->
          
            <div class="image" style="text-align: center;">
              <?php						
				if(file_exists("../../templates/registration/patient_photo/".$patientInfo[0][0]."/photo.jpg")){
				?>
				
				<img src="../../templates/registration/patient_photo/<?php echo $patientInfo[0][0];?>/photo.jpg" width="70px" height="60px" class="img-circle"><br>
				
				<?php
				 }else{						
				?>
				<img src="../../templates/registration/patient_photo/testimage.jpg" width="60px" height="70px" class="img-circle">
				<?php } ?>
            </div>
            <div  style="text-align: center;">
               <font color="white"><?php echo $patientInfo[0][1].' '.$patientInfo[0][2].' '.$patientInfo[0][3];?><br>
              <a href="#"><?php echo $patientInfo[0][4];?> / <?php echo $patientInfo[0][6];?></a></font>
            </div>
          <!-- search form -->
        
            <div class="text" style="text-align: center;">
             <font color="white">OPNO : <?php echo $patientInfo[0][0];?></font><br>
			 <font color="white">CONTACT NO : <?php echo $patientInfo[0][10];?></font>
            </div>
       
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" style="margin-top: 10px;">
            <li class="header">PATIENT HEALTH RECORD</li>
            <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'summary')?'active':'';?>"><a href="#" class="side_menu" id="summary"><i class="fa fa-dashboard"></i><span>Home</span></a>
            </li>
            <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_visits')?'active':'';?>"><a href="#" class="side_menu" id="patient_visits"><i class="fa fa-files-o"></i> <span>Patient Visits</span> </a></li>
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'case_sheets')?'active':'';?>"><a href="#" class="side_menu" id="case_sheets"><i class="fa fa-files-o"></i> <span>Case Sheets</span> </a></li>

			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'covid_status')?'active':'';?>"><a href="#" class="side_menu" id="covid_status"><i class="fa fa-files-o"></i> <span>Covid-19 Details</span> </a></li>

			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_lab_results')?'active':'';?>"><a href="#" class="side_menu" id="patient_lab_results"><i class="fa fa-files-o"></i> <span>Lab Results</span> </a></li>
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_medicines')?'active':'';?>"><a href="#" class="side_menu" id="patient_medicines"><i class="fa fa-files-o"></i> <span>Medicines</span> </a></li>
			<!-- <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_ip_history')?'active':'';?>"><a href="#" class="side_menu" id="patient_ip_history"><i class="fa fa-files-o"></i> <span>IP History</span> </a></li> -->
			<li  class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_op_bill_history')?'active':'';?>"><a href="#" class="side_menu" id="patient_op_bill_history"><i class="fa fa-files-o"></i> <span>OP Bill History</span> </a></li>	


            <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_op_credits')?'active':'';?>"><a href="#" class="side_menu" id="patient_op_credits"><i class="fa fa-files-o"></i> <span>OP Credits</span> </a></li>


			<!-- <li  class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_ip_bill_history')?'active':'';?>"><a href="#" class="side_menu" id="patient_ip_bill_history"><i class="fa fa-files-o"></i> <span>IP Bill History</span> </a></li>

			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_ip_credits')?'active':'';?>"><a href="#" class="side_menu" id="patient_ip_credits"><i class="fa fa-files-o"></i> <span>IP Credits</span> </a></li> -->
			
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_allergies')?'active':'';?>"><a href="#" class="side_menu" id="patient_allergies"><i class="fa fa-files-o"></i> <span>Allergies</span> </a></li>
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'patient_documents')?'active':'';?>"><a href="#" class="side_menu" id="patient_documents"><i class="fa fa-files-o"></i> <span>Documents</span> </a></li>
          </ul>   
           
        </section>
        <!-- /.sidebar -->
      </aside>

	   <div class="content-wrapper">
	   &nbsp;&nbsp;	&nbsp;<input type="button" name="back_to_list" id="back_to_list" class="btn btn-danger" value="Back to OP list" onclick="back_to_list();">
        <!-- Content Header (Page header) -->
        <form name="patient_record" id="form"  method="post" action=""> 
        <section class="content-header">
          <h1>
          <?php 
		 
		  if(!empty($post['active_module']) && $post['active_module'] == 'summary'){
			  echo $lang_summary_new; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_documents'){
			  echo $lang_documents; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_visits'){
			  echo $lang_patient_visits; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_lab_results'){
			  echo $lang_patient_lab_results; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'case_sheets'){
			  echo $lang_case_sheet; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_medicines'){
			  echo $lang_patient_medicines; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_ip_history'){
			  echo $lang_patient_ip_history; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_op_credits'){
			  echo $lang_op_credits; 
		  }
		  else if(!empty($post['active_module']) && $post['active_module'] == 'patient_allergies'){
			  echo $lang_allergies; 
		  }
		  // else if(!empty($post['active_module']) && $post['active_module'] == 'covid_status'){
			//   echo 'Covid - 19 Details'; 
		  // }
		   ?>
         </h1>
         
        </section>

        <!-- Main content -->
        <section class="content">
    <div class="row">
	
	<?php

		if (!empty($post['active_module']) && $post['active_module'] == 'summary') {?>

        <div class="col-md-6">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Personal Info</h3>
            
            </div>
            <div class="box-body">
              <div class="row">
                    <div class="col-xs-3">
                   <?php echo ucwords(strtolower($lang_phone_no)); ?>:<?php echo $patientInfo[0][10];?>
                    </div>
                    <div class="col-xs-4" align="center"> 
					<?php echo ucwords(strtolower($lang_place)); ?>:<?php echo ucwords(strtolower($patientInfo[0][8]));?>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div>
            </div><!-- /.box-body -->
            <!--<div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		  
		<!-- Case sheet -->
          <div class="box box-warning ">
            <div class="box-header with-border">
              <h3 class="box-title">Last Casesheet</h3>
            
            </div>
            <div class="box-body">
              <!-- presenting complaints---->
			  <?php 
			     $pcomplaints=$casesheetInfo[0];
			     
		             if(!empty($pcomplaints)){?>
			       <table class="table table-striped">
		                  
				 
				           <div class="direct-chat-info clearfix btn-warning" width="100%"><b><?php echo $lang_presenting_complaints;?></b></div>
				  <?php
				           for($i=0;$i<count($pcomplaints);$i++){?>
					   <tr >
					      <td><?php echo $pcomplaints[$i][3];?></td>
					      <td><?php echo $pcomplaints[$i][4];?></td>
					 </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>
				 <!-- provisional diagnosis---->
				 <?php 
			     $diagnosis=$casesheetInfo[1];
			     
		             if(!empty($diagnosis)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_provisional_diagnosis;?></div>
				   <?php 
				           for($i=0;$i<count($diagnosis);$i++){?>
					   <tr>
					      <td><?php echo $diagnosis[$i][3];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>
				 <!-- procedure---->
				 
			<?php
			    $procedures=$casesheetInfo[2];
			     
		             if(!empty($procedures)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_procedure));?></div>
				  <?php 
				           for($i=0;$i<count($procedures);$i++){?>
					   <tr >
					   <td><?php echo $procedures[$i][4];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }

			    $radiology=$casesheetInfo[5];
			     
		             if(!empty($radiology)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_radiology));?></div>
				  <?php 
				           for($i=0;$i<count($radiology);$i++){?>
					   <tr >
					   <td><?php echo $radiology[$i][4];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }

				
			    $labtest=$casesheetInfo[3];
			     
		             if(!empty($labtest)){?>
				 <table  class="table table-striped">
		               
		                  <div class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_lab." ".$lang_test));?></div>
		                  <?php 
				           for($i=0;$i<count($labtest);$i++){?>
					   <tr >
					   <td><?php echo $labtest[$i][4];?></td>					
					  </tr>
		    
			         <?php   }?>
				   </table>
				<?php }
			    $medicines=$casesheetInfo[4];
			     
		             if(!empty($labtest)){?>
				<table  class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_medicine_prescription;?></div>
		                <?php 
				           for($i=0;$i<count($medicines);$i++){?>
					   <tr >
					       <td><?php echo $medicines[$i][4];?></td>	
                                              <td><?php echo $medicines[$i][5];?></td>	
                                              <td><?php echo $medicines[$i][6];?></td>						      
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }
				 
			       $remarks=ucwords(strtolower($patientInfo[0][50]));
			     
		             if(!empty($remarks)){?>
			     <table  class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_remarks;?></div>
		              
					   <tr >
					       <td><?php echo $remarks;?></td>					
					   </tr>
		    
			         
				</table>
				<?php }
				  ?>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <a href="#" class="side_menu" id="case_sheets">View Details</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		   <!-- Credit Bills -->
          <div class="box box-danger ">
            <div class="box-header with-border">
              <h3 class="box-title">Credit Bills</h3>
            
            </div>
            <div class="box-body">
             <table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
                           <th ><a href="#"><?php echo $lang_balance; ?></a></th>						  
						
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($creditInfo)){
						     
						         for($i=0;$i<count($creditInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo $creditInfo[$i][16];?></td>
					  <td><?php echo $creditInfo[$i][11];?></td>
					  <td><?php echo $creditInfo[$i][14];?></td>
					
			<?php }
			
			  }
			?>
			</tbody>
			</table>
			<table class="table table-bordered table-striped">
				<thead>
				<tr><th colspan="4" >PHARMA CREDIT</th></tr>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th ><a href="#"><?php echo $lang_total_amount; ?></a></th>
                           <th ><a href="#"><?php echo $lang_balance; ?></a></th>						  
						
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($pharmaCreditInfo)){
						     
						         for($i=0;$i<count($pharmaCreditInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo date("d-m-Y",strtotime($pharmaCreditInfo[$i][15]));?></td>
					  <td><?php echo $pharmaCreditInfo[$i][2];?></td>
					  <td><?php echo $pharmaCreditInfo[$i][11];?></td>
					
			<?php }
			
			  }
			?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
            <div class="box-footer">
               <a href="#" id=>View Details</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		</div><!---col-md-6---->
		
		 <div class="col-md-6">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Visit Details</h3>
            
            </div>
            <div class="box-body">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th><a href="#"><?php echo $lang_doctor; ?></a></th>
						  <th ><a href="#"><?php echo $lang_date; ?></a></th>
						  <th width="5%"><a href="#"><?php echo $lang_status; ?></a></th>  
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($patientInfo)){
						     
						         for($i=0;$i<count($patientInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo $lang_dr.". ".$patientInfo[$i][15]." ".$patientInfo[$i][16];?></td>
					  <td><?php echo $patientInfo[$i][20]." ".$patientInfo[$i][19];?></td>
					  <td>
							<?php if($patientInfo[$i][41] == 1) echo "FREE";
									else echo $patientInfo[$i][32];?></td>
			<?php }
			
			  }
			?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <a href="#" class="side_menu" id="patient_visits">View Details</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		  <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">IP History</h3>
            
            </div>
            <div class="box-body">
             <table class="table table-bordered table-striped">
				<thead>
			
					<tr>
                          <th ><a href="#"><?php echo $lang_sl_no; ?></a></th>
						  <th ><a href="#"><?php echo $lang_ip_no; ?></a></th>
						  <th width="5%"><a href="#"><?php echo $lang_admitted_on; ?></a></th>
						   <th width="5%"><a href="#"><?php echo $lang_discharged_on; ?></a></th>
						   <th><a href="#"><?php echo $lang_room_no;?></a></th>	
					     					  
						
                </thead>
				<tbody>	
				
             <?php
			 
			      if(!empty($ipInfo)){
						     
						         for($i=0;$i<count($ipInfo);$i++){
				?>
				   <tr>
				      <td><?php echo $i+1;?></td>
					  <td><?php echo $ipInfo[$i][13];?></td>
					  <td><?php echo date("d-m-Y",strtotime($ipInfo[$i][20]));?></td>
					  <td><?php echo ($ipInfo[$i][22] !='0000-00-00')?date("d-m-Y",strtotime($ipInfo[$i][22])):"";?></td>
					  <td><?php echo $ipInfo[$i][37]."(BED:".$ipInfo[$i][38].")";?></td>
				   </tr>
					
			<?php }
			
			  }
			?>
			</tbody>
			</table>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <a href="#" id="patient_ip_history" class="side_menu">View Details</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		</div><!---col-md-6---->
	</div><!---row---->


		<?php
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_documents'){
			  
			  include("patient_documents.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_visits'){
			  
			  include("patient_visits.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_lab_results'){
			  
			  include("patient_lab_results.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'case_sheets'){
			  
			  include("case_sheets.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_medicines'){
			  
			  include("patient_medicines.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_ip_history'){
			  
			  include("patient_ip_history.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_op_bill_history'){
			  
			  include("patient_op_bill_history.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_ip_bill_history'){
			  
			  include("patient_ip_bill_history.php");
		}

		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_op_credits'){
			  
			  include("patient_op_credits.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_ip_credits'){
			  
			  include("patient_ip_credits.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'patient_allergies'){
			  
			  include("patient_allergies.php");
		}
		elseif(!empty($post['active_module']) && $post['active_module'] == 'covid_status'){
			  
			  include("covid_status.php");
		}

	 ?>

	
</section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<input type="hidden" name="id" id="id" value="<?php echo $post['id'];?>">
<input type="hidden" name="current_module" id="current_module" value="<?php echo $post['active_module'];?>">
<input type="hidden" name="patient_type" id="patient_type" value="<?php echo $post['patient_type'];?>">
</form>
	</body> 
</div>	
	  </html>