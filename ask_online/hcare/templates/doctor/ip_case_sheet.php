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
	 <link rel="stylesheet" href="../../dist/css/ajax.css">
   <script type="text/javascript" src="../../ajax/ajax.js"></script>
   <script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
  <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" type="text/css" href="../../dist/css/thickbox.css" />

  <link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
 <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="../../dist/js/thickbox.js"></script>
<script type="text/javascript" src="../../dist/js/thickbox_common.js"></script>

 <!-- iCheck 1.0.1 -->
    <script src="../../plugins/iCheck/icheck.js"></script>
	 <!-- Slimscroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<style type="text/css">
	#previousipdetails,#currentopdetails{
                                            margin-top: -41px;
	                                    }
</style>	
		
  <script>
 $('.main-header', window.parent.document).hide();
  $(document).ready(function(){
	  
	  $(".side_menu").bind('click', function() {

        var active_module=$(this).attr("id");

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=ip_case_sheet&active_module="+active_module);
   	    $("#form").submit();
    });
	 $(".print_prescription").bind('click', function() {

     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=dr_consulted&active_module=print_prescription");
   	    $("#form").submit();
		$('.main-header', window.parent.document).show();
    });
	
	 $("#is_diabetic").on('ifChanged', function(event){

    
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_ip_diabetic_status");
   	    $("#form").submit();
    });

	 $("#is_hyper_ten").on('ifChanged', function(event){

    
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_ip_hyper_tension_status");
   	    $("#form").submit();
    });

	$("#show_allergies").bind('click', function() {
      
	  var opid=$("#ipno").val();
      tb_show('ALLERGIES',"../../lib/controllers/centralController.php?module=Doctor&sub_module=ip_patient_allergies&ipno="+opid,'',450,250);
    });
	$(".lab_result").bind('click', function() {
      
	  var id=$(this).attr("id").split("lab");
	  billid=id[1];
      tb_show('LAB RESULT',"../../lib/controllers/centralController.php?module=Lab&sub_module=view_lab_result&billno="+billid,'',750,550);
    });
	 //iCheck for checkbox and radio inputs
    $('input').iCheck({
          checkboxClass: 'icheckbox_square-yellow',
         
    });
    $("#previousipdetails").bind('click', function() {

   	    var op_no = document.getElementById('opid').value;
        var ip_no = document.getElementById('ipno').value;
        window.open("../../lib/controllers/centralController.php?module=Doctor&sub_module=previous_ip_details&opnumb="+ op_no +"&ipnumb="+ ip_no ,"PREVIOUS IP DETAILS");

    });

    $("#currentopdetails").bind('click', function() {

   	    var op_no = document.getElementById('opid').value;
        window.open("../../lib/controllers/centralController.php?module=Doctor&sub_module=current_op_details&opnumb="+ op_no ,"CURRENT OP DETAILS");

    });



		
  });
  function back_to_list(user_type) {
   // alert(user_type);
   if(user_type == 'SUPER NURSE' || user_type == 'NURSE'){
   	window.location=("../../lib/controllers/centralController.php?module=Nurse&sub_module=inpatients");

   }else{
   	window.location=("../../lib/controllers/centralController.php?module=Doctor&sub_module=inpatients_list");

   }

  	
  	$('.main-header', window.parent.document).show();
  	 // window.open('../../index.php?current_menu=OPPatients');
        // $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=OPPatient_list");
   	    // $("#form").submit();
		


  }
  </script>
	
</head>
<?php
 	
 	$user_type=$_SESSION['user_type'];
 	// echo $user_type;

	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['postArr'];
	
	$allergicCount=$this  ->popArr['allergicCount'];
	$diabetic_status=$this  ->popArr['diabetic_status'];
	$is_hyper_ten=$this  ->popArr['is_hyper_ten'];
	$resultInfo=$this  ->popArr['resultInfo'];
	$ipno=$patientInfo[0][13];
?>
  <body class="hold-transition skin-blue sidebar-mini">
    

	<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
      
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">PATIENT HEALTH RECORD</li>
          
            <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_presenting_complaints')?'active':'';?>"><a href="#" class="side_menu" id="ip_presenting_complaints"><i class="fa fa-circle-o"></i> <span><?php echo $lang_presenting_complaints; ?></span> </a></li>
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_patient_physical_exam')?'active':'';?>"><a href="#" class="side_menu" id="ip_patient_physical_exam"><i class="fa fa-circle-o"></i> <span><?php echo $lang_physical_exam; ?></span> </a></li>
			
	<?php if(!empty($diabetic_status) && $diabetic_status[0][2] == "YES"){?>
	
	     <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_diabetic_analysis')?'active':'';?>"><a href="#" class="side_menu" id="ip_diabetic_analysis"><i class="fa fa-circle-o"></i> <span><?php echo $lang_diabetic_analysis; ?></span> </a></li>
			
	<?php } ?>
            <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_patient_allergies')?'active':'';?>"><a href="#" class="side_menu" id="ip_patient_allergies"><i class="fa fa-circle-o"></i> <span><?php echo $lang_allergies; ?></span> </a></li>
			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_patient_documents')?'active':'';?>"><a href="#" class="side_menu" id="ip_patient_documents"><i class="fa fa-circle-o"></i> <span><?php echo $lang_documents; ?></span> </a></li>

			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_patient_xray_documents')?'active':'';?>"><a href="#" class="side_menu" id="ip_patient_xray_documents"><i class="fa fa-circle-o"></i> <span><?php echo 'Xray '.$lang_documents; ?></span> </a></li>


		<!-- 	<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'refer_doctor')?'active':'';?>"><a href="#" class="side_menu" id="refer_doctor"><i class="fa fa-circle-o"></i> <span><?php echo $lang_reffer; ?></span> </a></li> -->

          <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_ot_note')?'active':'';?>"><a href="#" class="side_menu" id="ip_ot_note"><i class="fa fa-circle-o"></i> <span><?php echo 'OT Note'; ?></span> </a></li>

			<li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'ip_view_complete_note')?'active':'';?>"><a href="#" class="side_menu" id="ip_view_complete_note"><i class="fa fa-circle-o"></i> <span><?php echo $lang_view_complete_note; ?></span> </a></li>
			<!-- <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'print_prescription')?'active':'';?>"><a href="#" class="print_prescription" id="print_prescription"><i class="fa fa-circle-o"></i> <span><?php echo $lang_print_prescription; ?></span> </a></li> -->
			
          </ul>   
           
        </section>
        <!-- /.sidebar -->
      </aside>
<div class="wrapper">
	   <div class="content-wrapper">

	   &nbsp;&nbsp;&nbsp;<input type="button" name="back_to_list" id="back_to_list" class="btn btn-danger" value="Back to IP list " onclick="back_to_list('<?php echo $user_type;?>');">

	   <form name="casesheet" id="form"  method="post" action=""> 
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4 style="display: inline;margin-inline: 25px;">
          <?php 
		 
		  if(!empty($post['active_module']) && $post['active_module'] == 'ip_presenting_complaints'){
			  echo 'IP '.$lang_presenting_complaints; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_physical_exam'){
			  echo 'IP '.$lang_physical_exam; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_diabetic_analysis'){
			  echo 'IP '.$lang_diabetic_analysis; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_allergies'){
			  echo 'IP '.$lang_allergies; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_view_complete_note'){
			  echo 'IP '.$lang_view_complete_note; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_documents'){
			  echo 'IP '.$lang_documents; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_xray_documents'){
			  echo 'IP Xray '.$lang_documents; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_refer_doctor'){
			  echo 'IP '.$lang_reffer; 
		  }else if(!empty($post['active_module']) && $post['active_module'] == 'ip_ot_note'){
			  echo 'IP Operation Threatre Note'; 
		  } ?>
         </h4>
         
		  <ol class="breadcrumb">
                
				<li> <a href="#" class="btn btn-block btn-danger" data-toggle="dropdown" >
                  <i class="fa fa-hand-o-right label" ><?php echo $lang_hyper_tension;?></i>
                  <span class="label"><input type="checkbox" id="is_hyper_ten" name="is_hyper_ten" class="icheck" <?php echo (!empty($is_hyper_ten) && $is_hyper_ten[0][2] == "YES")?'checked':'';?>></span>
                </a></li>

				 <li> <a href="#" class="btn btn-block btn-danger" data-toggle="dropdown" >
                  <i class="fa fa-hand-o-right label" ><?php echo $lang_diabetic;?></i>
                  <span class="label"><input type="checkbox" id="is_diabetic" name="is_diabetic" class="icheck" <?php echo (!empty($diabetic_status) && $diabetic_status[0][2] == "YES")?'checked':'';?>></span>
                </a></li>
		       
				
				  <li > <a href="#" class="btn btn-block btn-info" data-toggle="control-sidebar" id="show_lab_result">
                  <i class="fa fa-hand-o-right label" ><?php echo ucwords(strtolower($lang_lab_result));?></i>
                  
                </a></li>
				
				 <li > <a href="#" class="btn btn-block btn-danger" data-toggle="dropdown" id="show_allergies">
                  <i class="fa fa-hand-o-right label" ><?php echo $lang_allergies;?></i>
                  <span class="label label-warning"><?php echo $allergicCount;?></span>
                </a></li>
				
	</ol>
        </section>
<br><br>
        <!-- Main content -->

 <section class="content">
 	
 	<a class="btn btn-success" id="previousipdetails"><i class="fa fa-hand-o-right label">Previous IP Details</i></a>
    <a class="btn btn-info" id="currentopdetails"><i class="fa fa-hand-o-right label">Current OP Details</i></a>

	<div class="row">
            

          <?php if(!empty($post['active_module']) && $post['active_module'] == 'view_complete_note'){	?>	
		  
		        <div class="col-md-8">	
				
		  <?php } else{?>

               <div class="col-md-6">
			  <?php } ?>   
                 <div class="box box-info">
                
                    <div class="box-body">
			<table class="table">
			
			 <tr>
			     <td><?php echo ucwords(strtolower($lang_ip_no)); ?>:<?php echo strtoupper($patientInfo[0][13]);?></td>
			    <td><?php echo ucwords(strtolower($lang_name)); ?>:<?php echo ucwords(strtolower(($patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3])));?></td>
			    <td><?php echo $patientInfo[0][4]."/".$patientInfo[0][6];?></td>
			  
			   
			   
			    <td rowspan="2" >  <?php						
						if(file_exists("../../templates/registration/patient_photo/".$patientInfo[0][0]."/photo.jpg")){
						?>
						
						<img src="../../templates/registration/patient_photo/<?php echo $patientInfo[0][0];?>/photo.jpg" width="80" height="80">
						<?php
						 }else{						
						?>
						<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
						<?php } ?>
			   </td>
		    </tr>
		    <tr>
			    
			     <td><?php echo ucwords(strtolower($lang_place)); ?>:<?php echo ucwords(strtolower($patientInfo[0][8]));?></td>
			     <td><?php echo ucwords(strtolower($lang_phone_no)); ?>:<?php echo (!empty($patientInfo[0][10]))?$patientInfo[0][10]:'';?></td>
			     <td></td>
			</tr>
			
			</table>
			
		</div>
	 <?php if(!empty($post['active_module']) && $post['active_module'] != 'view_complete_note'){	?>	
		  
		        </div>	
				
		  <?php } ?>
		
	
	    <?php 

	    if(!empty($post['active_module']) && $post['active_module'] == 'ip_presenting_complaints'){
	                   
			   include("ip_presenting_complaints.php");
					   
		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_physical_exam'){
			  
			  include("ip_patient_physical_exam.php");
		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_diabetic_analysis'){
			  
			  include("ip_patient_diabetic_analysis.php");
			 
		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_allergies'){
			  
			  include("ip_patient_allergies.php");
			  
		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_view_complete_note'){
			  
			  include("ip_view_complete_note.php");
		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_documents'){
			  
			  include("ip_patient_documents.php");

		}elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_patient_xray_documents'){
			  
			  include("ip_patient_xray_documents.php");

	    }elseif(!empty($post['active_module']) && $post['active_module'] == 'ip_ot_note'){
			  
			  include("ip_ot_notes.php");

		// }elseif(!empty($post['active_module']) && $post['active_module'] == 'refer_doctor'){
			  
		// 	  include("refer_doctor.php");

		}?>
	
	</div>
</section>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-light" style="height:730px">
	  <div class="box box-warning box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_lab_result;?>
		    </div>
			<?php if(!empty($resultInfo)){
				    for($i=0;$i<count($resultInfo);$i++){ ?>
					<br>
					     <p><a href="#" class="lab_result" id="lab<?php echo $resultInfo[$i][0];?>">Result <?php echo	$resultInfo[$i][16];?></a></p>
					<?php  }
			}?>
		</div>
	  
	   </aside><!-- /.control-sidebar -->
<input type="hidden" name="opid" id="opid" value="<?php echo $post['id'];?>">
<?php
     if(!empty($post['patient_ipno'])){
?>
<input type="hidden" name="ipno" id="ipno" value="<?php echo $post['patient_ipno'];?>">
<?php
     }else{
?>
<input type="hidden" name="ipno" id="ipno" value="<?php echo $post['ipno'];?>">
<?php
     }
?>
<input type="hidden" name="current_module" id="current_module" value="<?php echo $post['active_module'];?>">
<input type="hidden" name="patient_type" id="patient_type" value="<?php echo $post['patient_type'];?>">
</form>
      </div><!-- /.content-wrapper -->
	</body> 
</div>	
	  </html>