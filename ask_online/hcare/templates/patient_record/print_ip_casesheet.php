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
    	html,body{
    		height: 100%;
    	}
    }
</style>
 <script>
 	
     function closeWin() {
      window.close();
     }

  $(document).ready(function(){
	  
	
	 $(".patient_list").bind('click', function() {

     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=OPPatient_list");
   	    $("#form").submit();
    });
	$(".patient_history").bind('click', function() {

     
        $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=view_case_sheet&active_module=current_visit");
   	    $("#form").submit();
    });
  });
  </script>
<body>
<?php
	
$hobj=new HospitalInfo();
$hinfo=$hobj->getHospitalInfo();
$clinic_name=$hinfo[1];
$city=$hinfo[3];
$state=$hinfo[4];
$pincode=$hinfo[6];
$phone=$hinfo[7];
$casesheetInfo=$this  ->popArr['casesheetInfo'];

$patientInfo=$this  ->popArr['patient_info'];
$details=$this  ->popArr['details'];

?>
<form name="casesheet" id="form"  method="post" action=""> 

<section class="content">

	 <table width ="100%" >
	 	<tr>
			<td id="noborder" align="center"><img src="../../dist/img/logo.png" width="60px"></img></td>
		</tr> 
	 
	 	<tr>
		</tr>

		<?php

			if (!empty($post['is_dupclicate'])) {?>

				<td id="noborder" align="center" style="font-size: 12px;padding-top: 3px;"><label>(duplicate)</label></td>	

			<?php
			}


		?>

 	 	<tr>
			<td id="noborder" align="center" style="padding-top: 5px !important;"><strong><?php echo strtoupper($clinic_name);?></strong></td>
		</tr>
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo $city.", ".$state."-".$pincode;?></font></td>
		</tr>
		
		<tr>
			<td id="noborder"  align="center"><font size="<?php echo $lang_font_size;?>"><?php echo "TEL: ".$phone;?></font></td>
		</tr>
		</table>
	
		

	  <div class="row">
        <div class="col-md-12">	
          <!-- Default box -->
          <div class="box box-success">
           <!--  <div class="box-header with-border">
              <h3 class="box-title">Pattient Info</h3>
            
            </div> -->
            <div class="box-body">
            <div class="row">

			 <table class="table" style="margin-bottom: -19px;">
			<?php

				for ($i=0; $i <count($casesheetInfo) ; $i++) { ?>

					<tr>
					    <td rowspan="" style="width: 20%;"><?php						
								if(file_exists("../../templates/registration/patient_photo/".$patientInfo[$i][0]."/photo.jpg")){
								?>
								
								<img src="../../templates/registration/patient_photo/<?php echo $patientInfo[$i][0];?>/photo.jpg" width="80" height="80">
								<?php
								 }else{						
								?>
								<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
								<?php } ?>
					   </td>

					   	<td style="line-height: 30px;">
							<?php echo ucwords(strtolower($lang_name)); ?>:<?php echo strtoupper($patientInfo[$i][1])." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?><br>
							<?php echo ucwords(strtolower($lang_age)); ?>:<?php echo $patientInfo[$i][4]."/".$patientInfo[$i][6];?><br>
							<?php echo ucwords(strtolower($lang_place)); ?>:<?php echo $patientInfo[$i][8];?><br>
                            

						</td>

					  
					   	<td style="line-height: 30px;">
					   		<?php echo ucwords(strtolower($lang_doctor)); ?>:<?php echo "Dr ".strtoupper($patientInfo[$i][18]);?><br>
					   		<?php echo ucwords(strtolower($lang_date)); ?>:<?php echo ucwords(strtolower(($patientInfo[$i][20])));?><br>
					   			<?php echo ucwords(strtolower('Ipno')); ?>:<?php echo ucwords(strtolower(($patientInfo[$i][65])));?>
					   		
					   	</td>
					   							
				<!-- 	</tr>

					<tr> -->

						
					</tr>
					<!-- <tr>
						<td style="text-align: center;">
							<?php echo ucwords(strtolower($lang_age)); ?>:<?php echo $patientInfo[$i][4]."/".$patientInfo[$i][6];?>
						</td>
					</tr>
 -->

				<?php
			}
			?>
			</table>

</div>

            </div>
            </div><!-- /.box-body -->
            <!--<div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		  
		</div><!---col-md-6---->
		<div class="row">
          <div class="box box-success">
	
    <h3 class="box-title" >Casesheet Details</h3>
            
            </div>
            <table border="1">	
            <div class="box-body" >

		          <?php

					if(!empty($casesheetInfo)){
						$j=(($current_page-1)*$perPage)+1;
                    for($k=0;$k<count($casesheetInfo);$k++){

					
		          	$presenting_complaints=$casesheetInfo[$k][0];

	 				 if(!empty($presenting_complaints)){?>
	 
					<h4 class="box-title" style=" margin-top: -21px;"><u><?php  echo $lang_presenting_complaints; ?></u></h4>
			
					<?php for($i=0;$i<count($presenting_complaints);$i++){?>
						              
						<p><?php echo $presenting_complaints[$i][3];?>&nbsp;&nbsp;&nbsp;<?php echo $presenting_complaints[$i][4];?></p>

			     <?php   }
				  
				  	} 


				  	$past_history=$casesheetInfo[$k][8];

					if(!empty($past_history)){?>
 
					<h4 class="box-title"><u><?php  echo $lang_past_history; ?></u></h4>
		
					<?php for($i=0;$i<count($past_history);$i++){?>
					              
						<p><?php echo $past_history[$i][4];?></p>

			          <?php   }
				  
				  	}

				  	$procedure_presc=$casesheetInfo[$k][2]; 

					if(!empty($procedure_presc)){?>
							   
						<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_procedure));?></u></h4>
						<?php			           
						  for($i=0;$i<count($procedure_presc);$i++){?>
					              
								  <p><?php echo $procedure_presc[$i][4];?></p>
			          <?php   }
				  
				  	}


				  	$radiology_presc=$casesheetInfo[$k][11]; 

					if(!empty($radiology_presc)){?>
							   
						<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_radiology));?></u></h4>
						<?php			           
						  for($i=0;$i<count($radiology_presc);$i++){?>
					              
								  <p><?php echo $radiology_presc[$i][4];?></p>
			          <?php   }
				  
				  	}


				  	$labtest_presc=$casesheetInfo[$k][3];

					if(!empty($labtest_presc)){ ?>	
							
					      
							
							<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_lab))." ".ucfirst(strtolower($lang_test));?></u></h4>
							<?php
				           for($i=0;$i<count($labtest_presc);$i++){?>
					              
								  <p><?php echo $labtest_presc[$i][4];?></p>
			          <?php   }
				  
				  	} 

				  	$prov_diagnosis=$casesheetInfo[$k][1];

					if(!empty($prov_diagnosis)){?>
							
					      
							 <h4 class="box-title"><u><?php  echo $lang_diagnosis; ?></u></h4>
							<?php		           
							for($i=0;$i<count($prov_diagnosis);$i++){?>
					              
								  <p><?php echo $prov_diagnosis[$i][3];?></p>
			          <?php   }
				  
				  	} 

				  	$medicine_presc=$casesheetInfo[$k][4]; 

					if(!empty($medicine_presc)){?>
							
					       
							<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_medicine_prescription));?></u></h4>
							 <?php
				           for($i=0;$i<count($medicine_presc);$i++){?>
					              
								  <p><?php echo $medicine_presc[$i][4];?>
										&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$i][5];?>
										&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$i][6];?>			
								</p>
			          <?php   }
				  
				  	}

					$physical_examination=$casesheetInfo[$k][9]; 

				     	if(!empty($physical_examination)){ ?>
							
					      
							
							<?php		           
					for($i=0;$i<count($physical_examination);$i++){?>

             <h4 class="box-title"><u><?php echo $lang_physical_exam;?>(<?php echo date('d-m-Y h:i a',strtotime($physical_examination[$i][14]));?>)</u></h4>

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



			          <?php   }
				  
				  	}  
                
                	$allergies=$casesheetInfo[$k][10]; 

					if(!empty($allergies)){?>
							
					       
							<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_allergies));?></u></h4>
							 <?php
				           for($i=0;$i<count($allergies);$i++){?>
					              
								  <p>&nbsp;<?php echo $allergies[$i][3];?>
										&nbsp;&nbsp;&nbsp;<?php echo $allergies[$i][4];?>
										<!-- &nbsp;&nbsp;&nbsp;<?php echo $allergies[$i][5];?>			 -->
								</p>
			          <?php   }
				  
				  	}


$otnotes=$casesheetInfo[$k][12]; 

					if(!empty($otnotes)){?>
							
					       
							<h4 class="box-title"><u><?php echo ucfirst(strtolower('Operation Theatre Notes'));?></u></h4>
							 <?php
				           for($i=0;$i<count($otnotes);$i++){?>
					              
								  <p><?php// echo $otnotes[$i][3];?>
										<!-- &nbsp;&nbsp;&nbsp;<?php echo $otnotes[$i][4];?> -->
										&nbsp;<?php echo $otnotes[$i][5];?>			
								</p>
			          <?php   }
				  
				  	}





				  		$details=$casesheetInfo[$k][13];	

				  		if(!empty($details)){?>

				  			<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_advice));?></u></h4>
							<?php		           
							for($i=0;$i<count($details);$i++){?>

					        
					 			<?php
								  
								      $k=1;
							    for($i=0;$i<count($details);$i++){?>
								   
								  
								   <p><?php echo $details[$i][3];?></p>
								    <!-- <p ><?php echo $details[$i][4];?></p> -->
								  
								  
					    
						          <?php   } ?>
								 

			          <?php   }

			          	if(!empty($details)){?>

				  			<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_remarks));?></u></h4>
							<?php		           
							for($i=0;$i<count($details);$i++){?>

					        
					 			<?php
								  
								      $k=1;
							    for($i=0;$i<count($details);$i++){?>
								   
								  
								   <p><?php echo $details[$i][4];?></p>
								    <!-- <td ><?php echo $details[$i][4];?></td> -->
								  
								  
					    
						          <?php   } ?>
								

			          <?php   }
				  
				  
				  	}

				}

				}
						  
				//	} 

				}

				 ?>
                          
			
			 </div>
			</table>	
		     </div>
		</div>
	</div>
	<div align="center" class="DONTPrint"><a href="#" class="print_casesheet btn btn-warning btn-flat" onClick="Print()">PRINT</a>&nbsp;&nbsp;<a href="#" class="print_casesheet btn btn-danger btn-flat" onClick="closeWin()">CLOSE</a></div>

	</div>
	
</section>
<input type="hidden" name="opid" id="opid" value="<?php echo $post['id'];?>">
<input type="hidden" name="patient_type" id="patient_type" value="<?php echo $post['patient_type'];?>">
</form>
</body>
</html>