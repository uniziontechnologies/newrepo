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

	
<?php
	
$allergyInfo=$this  ->popArr['allergyInfo'];

$patientInfo=$this  ->popArr['patient_info'];
$physical_examination=$this  ->popArr['physical_examination'];
?>

<div id="content">
	<div class="row">
		<div class="col-md-12">
<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Physical Examination Info</h3>
            
            </div>
            <div class="box-body">


           <?php  	if(!empty($physical_examination)){ ?>
							
					      
							 <h4 class="box-title"><u><?php echo $lang_physical_exam;?></u></h4>
							<?php		           
					for($i=0;$i<count($physical_examination);$i++){?>
					              
<div class="box box-success">
	 <div class="box-header with-border">
              <h3 class="box-title"><?php echo date('d-m-Y h:i a',strtotime($physical_examination[$i][14]));?></h3>
            
            </div>
  <div class="box-body">
							 <table class="table table-striped">
						  
						         <?php if($physical_examination[$i][3] !=""){ ?>
						             <tr >
										   
										     <td ><?php echo $lang_temp;?></td><td><?php echo $physical_examination[$i][3];?>F</td>
									 </tr>
								 <?php } ?>
								 <?php if($physical_examination[$i][4] !=""){ ?>
										 <tr >
											<td><?php echo $lang_pulse;?></td><td><?php echo $physical_examination[$i][4];?>bpm</td>
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][5] !=""){ ?>
										 <tr >
											<td><?php echo $lang_bp;?></td><td><?php echo $physical_examination[$i][5];?>(mm/hg)</td>
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][6] !=""){ ?>
										 <tr >
											<td ><?php echo $lang_height;?></td><td><?php echo $physical_examination[$i][6];?>cm</td>
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][7] !=""){ ?>
										 <tr >
											<td><?php echo $lang_weight;?></td><td><?php echo $physical_examination[$i][7];?>kgs</td>
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][8] !=""){ ?>
										 <tr >
											<td><?php echo $lang_bmi;?></td><td><?php echo $physical_examination[$i][8];?></td>
										    
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][9] !=""){ ?>
										 <tr >
										   
										     <td><?php echo $lang_resp_rate;?></td><td><?php echo $physical_examination[$i][9];?>rpm</td>
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][10] !=""){ ?>
										 <tr >
											<td><?php echo $lang_oxy_saturation;?></td><td><?php echo $physical_examination[$i][10];?>%</td>
											
										    
										 </tr>
								 <?php } ?>
								<?php if($physical_examination[$i][11] !=""){ ?>
										 <tr>
												  <td><?php echo $lang_gen_condition;?></td>
												  
												<!-- </tr> -->
												<!-- <tr> -->
												  <td ><p><?php echo $physical_examination[$i][11];?></p>
												  </td>
												 </tr>
									 <?php } ?>
							</table>
</div>
</div>


			          <?php   }
				  
				  	}  ?>

        </div>

  </div>
</div>


<!-- <input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
 -->

<script type="text/javascript">
	
	  $(document).ready(function() {  	
	
	    $('#inner-content-div').slimScroll({
	        height: '400px'
	    });

	    $('#inner-content-div h4').css('font-size','17px');

	   });

     
	 


</script>


