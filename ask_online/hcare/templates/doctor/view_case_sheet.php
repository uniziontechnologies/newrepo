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


	 <!-- Slimscroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
	  <script>
  $(document).ready(function(){
	   $(".side_menu").bind('click', function() {

        var active_module=$(this).attr("id");

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&active_module="+active_module);
   	    $("#form").submit();
    });
	  $(".side_menu_casesheet").bind('click', function() {

       var res = $(this).attr('id').split("visit");
      var id_selected=res[1];

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&id_selected="+id_selected+'&active_module=casesheet_history');
   	    $("#form").submit();
    });
	$(".side_menu_lab_result").bind('click', function() {

       var res = $(this).attr('id').split("labid");
      var id_selected=res[1];

        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&id_selected="+id_selected+'&active_module=view_lab_result');
   	    $("#form").submit();
    });
	 $(".print_casesheet").bind('click', function() {
     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=print_prescription&active_module=view_case_sheet");
   	    $("#form").submit();
    });
   });

</script>
  

<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$post=$this  ->popArr['postArr'];
	$casesheetInfo=$this  ->popArr['casesheetInfo'];
	$labresultInfo=$this  ->popArr['labresultInfo'];
    $diabetic_status=$this  ->popArr['diabetic_status'];
	

    $presenting_complaints=$this  ->popArr['presenting_complaints'];
	$prov_diagnosis=$this  ->popArr['prov_diagnosis'];
	$procedure_presc=$this  ->popArr['procedure_presc'];
	$labtest_presc=$this  ->popArr['labtest_presc'];
	$medicine_presc=$this  ->popArr['medicine_presc'];
	$physical_examination=$this  ->popArr['physical_examination'];
	$allergicInfo=$this ->popArr['allergicInfo'];
	$past_history=$this ->popArr['past_history'];
	$radiology_presc=$this ->popArr['radiology_presc'];
	$referalInfo=$this ->popArr['referalInfo'];

	
?>
<body class="hold-transition skin-blue sidebar-mini">

  <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
      
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
          
			 <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'current_visit')?'active':'';?>"><a href="#" class="side_menu" id="current_visit"><i class="fa fa-files-o"></i> <span><?php echo ucwords(strtolower($lang_visit_history));?></span> </a></li>
			<li class="treeview<?php echo ((!empty($post['active_module']) && $post['active_module'] == 'casesheet_history'))?' active':'';?>">
              <a href="#">
                <i class="fa fa-share"></i> <span><?php echo ucwords(strtolower($lang_casesheet_history));?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  
			  <?php if(!empty($casesheetInfo)){

                    for($k=0;$k<count($casesheetInfo);$k++){    ?>	    
                         <li class="<?php echo ((!empty($post['opid_selected']) && $post['opid_selected'] == $casesheetInfo[$k][5]))?'active':'';?>">
						     <a href="#" class="side_menu_casesheet" id="visit<?php echo $casesheetInfo[$k][5];?>">
							    <i class="fa fa-circle-o"></i> <?php echo $casesheetInfo[$k][6];?>
							</a></li>
						 
					<?php  }
			  }
			  ?>
               
			 </ul>
			 </li>
			 <li class="treeview<?php echo ((!empty($post['active_module']) && $post['active_module'] == 'view_lab_result'))?' active':'';?>">
              <a href="#">
                <i class="fa fa-share"></i> <span><?php echo ucwords(strtolower($lang_lab_result));?></span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  
			  <?php if(!empty($labresultInfo)){

                    for($k=0;$k<count($labresultInfo);$k++){    ?>	    
                         <li class="<?php echo ((!empty($post['labid_selected']) && $post['labid_selected'] == $labresultInfo[$k][0]))?'active':'';?>">
						     <a href="#" class="side_menu_lab_result" id="labid<?php echo $labresultInfo[$k][0];?>">
							    <i class="fa fa-circle-o"></i>Result <?php echo $labresultInfo[$k][16];?>
							</a></li>
						 
					<?php  }
			  }
			  ?>
               
			 </ul>
			 </li>
			 <?php if(!empty($diabetic_status) && $diabetic_status[0][2] == "YES"){?>
	
	     <li class="<?php echo (!empty($post['active_module']) && $post['active_module'] == 'diabetic_analysis')?'active':'';?>"><a href="#" class="side_menu" id="diabetic_analysis"><i class="fa fa-circle-o"></i> <span><?php echo $lang_diabetic_analysis; ?></span> </a></li>
			
	<?php } ?>
		 </ul>
		</section>
	  <!-- /.sidebar -->
   </aside>
   <div class="wrapper">
	   <div class="content-wrapper">
<form name="casesheet" id="form"  method="post" action=""> 
 <section class="content">
	<div class="row">
	   <div class="col-md-8">
	   
	   <div class="box box-info">
                
                    <div class="box-body">
					<?php if(!empty($post['active_module']) && ($post['active_module'] != 'view_lab_result')){ ?>
							<table class="table">
							
							 <tr>
								<td><?php echo ucwords(strtolower($lang_op_no)); ?>:<?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?></td>
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
								 <td><?php echo ucwords(strtolower($lang_phone_no)); ?>:<?php echo $patientInfo[0][10];?></td>
								 <td><?php echo ucwords(strtolower($lang_visited_on)); ?>:<?php echo $patientInfo[0][20];?></td>
							</tr>
							
							</table>
						<?php if(!empty($post['active_module']) && $post['active_module'] == 'current_visit'){ ?>
							 <p><a href="#" class="print_casesheet btn btn-info btn-flat" >PRINT PRESCRIPTION</a></p>
						<?php } 
				       if(!empty($post['active_module']) && $post['active_module'] == 'diabetic_analysis'){
			  
			                       include("show_diabetic_readings.php");
			  
		                }else{
					    include("view_complete_note.php"); 
						
						}?>
         
		
                       
         <?php }else if(!empty($post['active_module']) && ($post['active_module'] == 'view_lab_result')){ 
		
                      include("view_lab_result.php"); 
          }?>
        </div>	   
	
	</div>
 </section>
 <input type="hidden" name="opid" id="opid" value="<?php echo $post['id'];?>">
 </form>
 </div>	   
	
	</div>

</body>