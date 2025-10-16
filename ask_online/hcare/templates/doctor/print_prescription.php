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
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
    
     <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>   
  <script type="text/javascript" src="../../dist/js/common_functions.js">  </script>
  
  <style>
    @media print{
		@page{
			    size: auto;margin:0mm 10mm 0mm 0mm;
			    margin-top: 3cm;
			  }

    	html,body{
    		height: 100%;
    	}
    }
    *{
    	font-size: 12px !important;
    }
.table-condensed > tbody > tr > td, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > td, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > thead > tr > th {
    padding: 0px !important;
}

</style>
 <script>
  $(document).ready(function(){
	  
	
	 $(".patient_list").bind('click', function() {

     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=OPPatient_list");
   	    $("#form").submit();
    });
	$(".patient_history").bind('click', function() {

     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&active_module=current_visit");
   	    $("#form").submit();
    });

	$("#show_phy").bind('click', function() {

     	if ($('#show_phy').is(':checked')) {
     		 $("#show_phy_div").removeClass('DONTPrint');
     	}
     	else{
     		$("#show_phy_div").addClass('DONTPrint');
     	}
        
    });

  });
  </script>
<body>
<?php
	
	$patientInfo=$this  ->popArr['patient_info'];
	$drInfo=$this  ->popArr['dr_info'];
	$post=$this  ->popArr['postArr'];
	$presenting_complaints=$this  ->popArr['presenting_complaints'];
	$prov_diagnosis=$this  ->popArr['prov_diagnosis'];
	$procedure_presc=$this  ->popArr['procedure_presc'];
	$labtest_presc=$this  ->popArr['labtest_presc'];
	$medicine_presc=$this  ->popArr['medicine_presc'];
	$physical_examination=$this  ->popArr['physical_examination'];
	
?>
<form name="casesheet" id="form"  method="post" action=""> 

<section class="content">

	<div class="row">
             <div class="col-md-6">				 
               
	      <div class="box">
                
                      <div class="box-body">
					<br><br>
					<!--   <div class="row">
                    <div class="col-xs-3">
                    
                    </div>
                    <div class="col-xs-4" align="center"><strong><u>PRESCRIPTION</u></strong>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div> -->
				  
					  <div class="row">
					   <div class="col-xs-12"><b>
					      <?php echo ucwords(strtolower($lang_dr)); ?>.<?php echo $patientInfo[0][15]." ".$patientInfo[0][16];?></b>
						  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						  <br>
						  <?php 
						  if(!empty($drInfo[0][9])){
						     echo ucwords(strtolower($lang_department));?> :  <?php echo $drInfo[0][9];
						  } 
							?>
						  
						 <?php if(!empty($drInfo[0][16])){ ?>
						  <!-- <br> -->
						  <?php echo $drInfo[0][16];;?>
						<?php } ?>
						 
						<?php if(!empty($drInfo[0][15])){ ?>
						  <!-- <br> -->
						  Reg No:<?php echo $drInfo[0][15];;?>
						<?php } ?>
					   </div>
					  </div>
					 
				  <div class="row">
                    <div class="col-xs-7">
                       <?php echo ucwords(strtolower($lang_name)); ?>:<?php echo ucwords(strtolower(($patientInfo[0][1]." ".$patientInfo[0][2]." ".$patientInfo[0][3])));?>
                    </div>
                   
                    <div class="col-xs-5">
                     <?php echo ucwords(strtolower($lang_age)); ?>:<?php echo $patientInfo[0][4]."/".$patientInfo[0][6];?>
                    </div>
                  </div>
		         <div class="row">
                    <div class="col-xs-7">
                     <?php echo ucwords(strtolower($lang_place)); ?>:<?php echo ucwords(strtolower($patientInfo[0][8]));?>
                    </div>

                   
                    <div class="col-xs-5">
                    <?php echo ucwords(strtolower($lang_address)); ?>:<?php echo ($patientInfo[0][92]);?>
                    </div>
                   
                  </div>
				   <div class="row">
                    <div class="col-xs-7">
                     <?php echo ucwords(strtolower($lang_date)); ?>:<?php echo date("d-m-Y",strtotime($patientInfo[0][20]))." ".$patientInfo[0][19];?>
                    </div>
                    <div class="col-xs-5">
                    <?php echo ucwords(strtolower($lang_op_no)); ?>:<?php echo strtoupper($patientInfo[0][47])."/".$patientInfo[0][0];?>
                    </div>

                  </div>
                  <br>
					  <div class="row" style="margin-top: -15px;">
                    <div class="col-xs-3">
                    
                    </div>
                    <div class="col-xs-4" align="center"><strong><u>PRESCRIPTION</u></strong>
                    </div>
                    <div class="col-xs-5">
					
                    </div>
                  </div>

		       <div class="row">
			        <div style="float:left;width:100%;margin-left:10px;margin-top: -10px;" >
					
					<?php if(!empty($prov_diagnosis)){?>
			           <br> <strong><u><?php echo strtoupper($lang_diagnosis);?></u></strong>
			             <?php
					for($i=0;$i<count($prov_diagnosis);$i++){?>
			    
			                  <div class="row">
							   <div class="col-xs-5"><?php echo strtoupper($prov_diagnosis[$i][3]);?></div>
							  </div>
			     <?php } ?>
			   
			   <?php }?>
					
					</div>
				</div>
				  <?php if(!empty($medicine_presc)){?>
					<br>
					<table width="100%" class="table table-condensed">
					<tbody>
					  <tr style="font-size:14px;">
					     <td >Sl No</td><td>Drug Name</td><td>Dosage</td><td style="visibility: hidden;">Duration (days)</td><td>Outside</td>
					  </tr>
					<?php
					  for($i=0;$i<count($medicine_presc);$i++){?>
			                <tr style="font-size:12px;">
							 <td><?php echo $i+1;?></td>
							 <td><?php echo (strtoupper($medicine_presc[$i][4]));?></td>
							  <td><?php echo $medicine_presc[$i][5];?></td>
							   <td><?php echo $medicine_presc[$i][6]?></td>
							   <td><?php if($medicine_presc[$i][3] == 0) {echo "YES";}else{echo " - ";}?></td>
					
				 <?php }?>
				 </tbody>
				 </table>
				 <?php
				  }
				  ?>
				  <br>

				  <?php 

				  	if (!empty($physical_examination)) {?>

						<div id="show_phy_div">
							
							<table width="100%" class="table table-condensed">

								<tbody>
									
									<tr style="font-size:14px;">
										<td>Temp</td>
										<td>Pulse</td>
										<td>Bp</td>
										<td>02 Saturation</td>
										<td ></td>
									</tr>

									<tr style="font-size:14px;">
										
										<td><?php echo $physical_examination[0][3]; ?></td>
										<td><?php echo $physical_examination[0][4]; ?></td>
										<td><?php echo $physical_examination[0][5]; ?></td>
										<td><?php echo $physical_examination[0][10]; ?></td>
										<td class="DONTPrint"><input type="checkbox" name="show_phy" id="show_phy" value="show_phy" class="DONTPrint" checked style="width: 35px !important;height: 35px !important;float: right;"></td>

									</tr>

								</tbody>

							</table>

						</div>

				  		
				  	<?php
				  	}

				  ?>

				  <?php
				  if((!empty($patientInfo[0][55]) && $patientInfo[0][55]!='0000-00-00')){
				 ?>
				
				  <p><b><?php echo ucwords(strtolower($lang_followup_date)); ?>&nbsp;: <?php echo (!empty($patientInfo[0][55]) && $patientInfo[0][55]!='0000-00-00')?$patientInfo[0][55]:'';?></b></p>
	             
				  <?php } ?>
				  <!-- <br> -->

				  <?php 

				  	if (!empty($patientInfo[0][88])) {?>

						<p><b><?php echo "Advice &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".(strtoupper($patientInfo[0][88]));?></b></p>
						<!-- <br> -->

				  	<?php
				  	}

				  ?>

				  <?php 

				  	if (!empty($patientInfo[0][50])) {?>
				  		
						<p><b><?php echo "Remarks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".(strtoupper($patientInfo[0][50]));?></b></p>

				  	<?php
				  	}

				  ?>


				 <!-- removed request by dr muhammed ali-->
				<!--<div style="float:right;width:40%;" ><b><?php echo ucwords(strtolower($lang_dr)); ?>.<?php echo ucwords(strtolower(($patientInfo[0][15]." ".$patientInfo[0][16])));?></b></div>-->
				<div style="float:right;width:40%;" ><b><?php echo ucwords(strtolower($lang_dr)); ?>.<?php echo $patientInfo[0][15]." ".$patientInfo[0][16];?></b></div>
				
				<br><div align="center">---------------End Of Prescription---------------</div>
                          
			
			 
		     </div>
		</div>
	</div>
	
	</div>
	<div align="center" class="DONTPrint"><a href="#" class="print_casesheet btn btn-warning btn-flat" onClick="Print()">PRINT</a>
	<?php if((!empty($post['active_module']) && $post['active_module'] == 'view_case_sheet')){?>
	&nbsp;&nbsp;&nbsp;<a href="#" class="patient_history btn btn-success btn-flat">VIEW PATIENTS HISTORY</a></div>
	<?php }else{ ?>
	&nbsp;&nbsp;&nbsp;<a href="#" class="patient_list btn btn-success btn-flat">OP PATIENTS LIST</a></div>
	<?php } ?>
</section>
<input type="hidden" name="opid" id="opid" value="<?php echo $post['id'];?>">
<input type="hidden" name="patient_type" id="patient_type" value="<?php echo $post['patient_type'];?>">
</form>
</body>
</html>