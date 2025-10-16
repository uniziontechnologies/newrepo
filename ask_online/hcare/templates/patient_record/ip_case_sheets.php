
<script type="text/javascript">
	
	  $(document).ready(function() {  	
	
	    $('#inner-content-div').slimScroll({
	        height: '400px'
	    });

	    $('#inner-content-div h4').css('font-size','17px');

	   });

      $(function () {
	  
	  	  $(".next_page").bind('click', function() {

	  	  		 $("#visit_date").val("");
			  
			     var current_page= $("#current_page").val();
				 current_page++;
				 $("#current_page").val(current_page);
				 var active_module="ip_case_sheets";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });
		 $(".prev_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");

			     var current_page= $("#current_page").val();
				 current_page--;
				 $("#current_page").val(current_page);
				 var active_module="ip_case_sheets";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });
			   $(".change_page").bind('click', function() {
			  	 
			  	 $("#visit_date").val("");

			     var current_page= $(this).attr("id");
				 $("#current_page").val(current_page);
				 var active_module="ip_case_sheets";
				  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record&active_module="+active_module);
				 $("#form").submit();
			  });	

			   $("#visit_date").bind('change', function() {
			  	
			  		var visit_id= $(this).val();

			  		$("#current_page").val("");

			  		$(".pagination").val("");

					 var active_module="ip_case_sheets";
					  $("#form").attr("action","../../lib/controllers/centralController.php?module=Registration&sub_module=ip_View_Patient_Record&active_module="+active_module);
					 $("#form").submit();

			  		
					
			  });	

	  });


</script>



<?php
	
$patient_info_dropdown=$this  ->popArr['patient_info_dropdown'];
$casesheetInfo=$this  ->popArr['casesheetInfo'];
$physical_examination=$this  ->popArr['physical_examination'];
$pagination=$this  ->popArr['pagination'];
$current_page=$this  ->popArr['current_page'];
$perPage=$this  ->popArr['perPage'];
$date_selected=$this  ->popArr['date_selected'];
$details=$this  ->popArr['details'];
	
?>

<style type="text/css">

ul.pagination.pagination-sm.no-margin.pull-right {
    float: left !important;
}
@media print{
	html,body{
		height: 100% !important;
	}
}
.col-md-3.case_sheet_date {
    font-weight: 700 !important;
}
</style>

    <!-- Main content -->
    <section class="content">


    <div class="box box-info">

   	  <div class="row DONTPrint">
   	  	
   	  	<div class="col-md-offset-7 col-md-2">
   	  		
   	  		<!-- <select id="visit_date" name="visit_date" class="form-control">
   	  			<option value=""> Please Select </option>
   	  			<?php

   	  				for ($i=0; $i <count($patient_info_dropdown) ; $i++) { ?>
   	  					<option value="<?php echo $patient_info_dropdown[$i][13]; ?>" <?php if (!empty($patient_info_dropdown[$i]) && $patient_info_dropdown[$i][13]==$date_selected ) {
   	  						echo "selected";
   	  					} ?> ><?php echo $patient_info_dropdown[$i][20]; ?></option>
   	  				<?php
   	  				}

   	  			?>
   	  		</select> -->

   	  	</div>

   	  	<div class="col-md-3">
   	  		<?php echo $pagination;?>
   	  	</div>

   	  </div>
   </div>


    <div class="row">


        <div class="col-md-4">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Pattient Info</h3>
            
            </div>
            <div class="box-body">
            <div class="row">

			 <table class="table">
			<?php

				for ($i=0; $i <count($casesheetInfo) ; $i++) { ?>

					<tr>
					    <td rowspan="1" style="text-align: center;"><?php						
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
					   		<?php echo ucwords(strtolower($lang_doctor)); ?>:<?php echo "Dr ".strtoupper($patientInfo[$i][18]);?><br>
					   		<?php echo ucwords(strtolower($lang_date)); ?>:<?php echo ucwords(strtolower(($patientInfo[$i][20])));?><br>
					   			<?php echo ucwords(strtolower('Ipno')); ?>:<?php echo ucwords(strtolower(($patientInfo[$i][13])));?>
					   		
					   	</td>
					   							
					</tr>

					<tr>

						<td style="text-align: center;">
							<?php echo ucwords(strtolower($lang_name)); ?>:<?php echo strtoupper($patientInfo[$i][1])." ".$patientInfo[$i][2]." ".$patientInfo[$i][3];?></td>

					</tr>
					<tr>
						<td style="text-align: center;">
							<?php echo ucwords(strtolower($lang_age)); ?>:<?php echo $patientInfo[$i][4]."/".$patientInfo[$i][6];?>
						</td>
					</tr>


				<?php
			}
			?>
			</table>



            </div>
            </div><!-- /.box-body -->
            <!--<div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
		  
		</div><!---col-md-6---->
		
		 <div class="col-md-8">	
          <!-- Default box -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Casesheet Details</h3>
            
            </div>
            <div class="box-body" >

		          <?php

					if(!empty($casesheetInfo)){
						$j=(($current_page-1)*$perPage)+1;
                    for($k=0;$k<count($casesheetInfo);$k++){

					
		          	$presenting_complaints=$casesheetInfo[$k][0];

	 				 if(!empty($presenting_complaints)){?>
	 
					<h4 class="box-title"><u><?php  echo $lang_presenting_complaints; ?></u></h4>
			
					<?php for($i=0;$i<count($presenting_complaints);$i++){?>

						<div class="col-md-7">
							
							<p><?php echo $presenting_complaints[$i][3];?></p>

						</div>

						<div class="col-md-2">
							
							<p><?php echo $presenting_complaints[$i][4];?></p>
							
						</div>

						<div class="col-md-3 case_sheet_date">
							
							<p><?php echo date("d-m-Y h:i A",strtotime($presenting_complaints[$i][5]));?></p>
							
						</div>

			     <?php   }
				  
				  	} 


				  	$past_history=$casesheetInfo[$k][8];

					if(!empty($past_history)){?>
 
					<h4 class="box-title"><u><?php  echo $lang_past_history; ?></u></h4>
		
					<?php for($i=0;$i<count($past_history);$i++){?>
					              
						<div class="col-md-9">
							
							<p><?php echo $past_history[$i][4];?></p>
							
						</div>

						<div class="col-md-3 case_sheet_date">
							
							<p><?php echo date("d-m-Y h:i A",strtotime($past_history[$i][5]));?></p>
							
						</div>



			          <?php   }
				  
				  	}

				  	$procedure_presc=$casesheetInfo[$k][2]; 

					if(!empty($procedure_presc)){?>
							   
						<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_procedure));?></u></h4>
						<?php			           
						  for($i=0;$i<count($procedure_presc);$i++){?>
					              
							<div class="col-md-9">
								
								<p><?php echo $procedure_presc[$i][4];?></p>
								
							</div>

							<div class="col-md-3 case_sheet_date">
								
								<p><?php echo date("d-m-Y h:i A",strtotime($procedure_presc[$i][5]));?></p>
								
							</div>

			          <?php   }
				  
				  	}


				  	$radiology_presc=$casesheetInfo[$k][11]; 

					if(!empty($radiology_presc)){?>
							   
						<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_radiology));?></u></h4>
						<?php			           
						  for($i=0;$i<count($radiology_presc);$i++){?>

								<div class="col-md-9">
									
									<p><?php echo $radiology_presc[$i][4];?></p>
									
								</div>

								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($radiology_presc[$i][5]));?></p>
									
								</div>

			          <?php   }
				  
				  	}


				  	$labtest_presc=$casesheetInfo[$k][3];

					if(!empty($labtest_presc)){ ?>	
					      
							
							<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_lab))." ".ucfirst(strtolower($lang_test));?></u></h4>
							<?php
				           for($i=0;$i<count($labtest_presc);$i++){?>
					              
								<div class="col-md-9">
									
									<p><?php echo $labtest_presc[$i][4];?></p>
									
								</div>

								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($labtest_presc[$i][6]));?></p>
									
								</div>

			          <?php   }
				  
				  	} 

				  	$prov_diagnosis=$casesheetInfo[$k][1];

					if(!empty($prov_diagnosis)){?>
							
					      
							 <h4 class="box-title"><u><?php  echo $lang_diagnosis; ?></u></h4>
							<?php		           
							for($i=0;$i<count($prov_diagnosis);$i++){?>
								  
								<div class="col-md-9">
									
									<p><?php echo $prov_diagnosis[$i][3];?></p>
									
								</div>

								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($prov_diagnosis[$i][4]));?></p>
									
								</div>

			          <?php   }
				  
				  	} 

				  	$medicine_presc=$casesheetInfo[$k][4]; 

					if(!empty($medicine_presc)){?>
							
					       
							<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_medicine_prescription));?></u></h4>
							 <?php
				           for($i=0;$i<count($medicine_presc);$i++){?>
					              

								<div class="col-md-5">
									
									<p><?php echo $medicine_presc[$i][4];?></p>
									
								</div>

								<div class="col-md-2">
									
									<p><?php echo $medicine_presc[$i][5];?></p>
									
								</div>

								<div class="col-md-2">
									
									<p><?php echo $medicine_presc[$i][6];?></p>
									
								</div>



								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($medicine_presc[$i][7]));?></p>
									
								</div>

			          <?php   }
				  
				  	}
	     $physical_examination=$casesheetInfo[$k][9]; 

				     	if(!empty($physical_examination)){ ?>
							
					      
							
							<?php		           
					for($i=0;$i<count($physical_examination);$i++){?>

                    <h4 class="box-title"><u><?php echo $lang_physical_exam;?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo date('d-m-Y h:i A',strtotime($physical_examination[$i][14]));?>)</u></h4>

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
					              
								<div class="col-md-9">
									
									<p><?php echo $allergies[$i][3];?></p>
									
								</div>

								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($allergies[$i][6]));?></p>
									
								</div>

			          <?php   }
				  
				  	}


           $otnotes=$casesheetInfo[$k][12]; 

					if(!empty($otnotes)){?>
							
					       
							<h4 class="box-title"><u><?php echo ucfirst(strtolower('Operation Theatre Notes'));?></u></h4>
							 <?php
				           for($i=0;$i<count($otnotes);$i++){?>
					              

								<div class="col-md-9">
									
									<p><?php echo $otnotes[$i][5];?></p>
									
								</div>

								<div class="col-md-3 case_sheet_date">
									
									<p><?php echo date("d-m-Y h:i A",strtotime($otnotes[$i][6]));?></p>
									
								</div>

			          <?php   }
				  
				  	}



				  		$details=$casesheetInfo[$k][13];	

				  		if(!empty($details)){?>

				  			<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_advice));?></u></h4>
							<?php		           
							for($i=0;$i<count($details);$i++){?>

					        
					 			<?php
								  
								      $k=1;
							    for($i=0;$i<count($details);$i++){

							    	if (!empty($details[$i][3])) {?>


										<div class="col-md-9">
											
											<p><?php echo $details[$i][3];?></p>
											
										</div>

										<div class="col-md-3 case_sheet_date">
											
											<p><?php echo date("d-m-Y h:i A",strtotime($details[$i][6]));?></p>
											
										</div>

							    	<?php
							    	}

							    	?>
								   
								  
	

								  
					    
						          <?php   } ?>
								 

			          <?php   }

			          	if(!empty($details)){?>

				  			<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_remarks));?></u></h4>
							<?php		           
							for($i=0;$i<count($details);$i++){?>

					        
					 			<?php
								  
								      $k=1;
							    for($i=0;$i<count($details);$i++){

							    	if (!empty($details[$i][4])) {?>

										<div class="col-md-9">
											
											<p><?php echo $details[$i][4];?></p>
											
										</div>

										<div class="col-md-3 case_sheet_date">
											
											<p><?php echo date("d-m-Y h:i A",strtotime($details[$i][6]));?></p>
											
										</div>


							    	<?php
							    	}

							    	?>
								   
					    
						          <?php   } ?>
								

			          <?php   }
				  
				  
				  	}

				}

				}
						  
				//	} 

				}

				 ?>

<!-- <div align="center" class="DONTPrint"><a href="#" class="print_casesheet btn btn-warning btn-flat" onClick="Print()">PRINT</a></div> -->


<div align="center" class="DONTPrint"><a href="../../lib/controllers/centralController.php?module=Registration&sub_module=print_ip_casesheet&id=<?php echo $patientInfo[0][13];?>" target="_blank" name="button" class="btn btn-primary btn-sm " id="<?php echo $patientInfo[0][13]; ?>">PRINT</a></div>

            </div><!-- /.box-body -->

          </div><!-- /.box -->

		</div><!---col-md-6---->
	</div><!---row---->

</section><!-- /.content -->


<input type='hidden' name='current_page' id='current_page' value="<?php echo $current_page;?>">
