<script>
	
	  $(document).ready(function() {  	
	
    $('#inner-content-div').slimScroll({
        // height: '250px'
        height: '100%';
    });

	   });
	</script>
	
<?php

    $presenting_complaints=$this  ->popArr['presenting_complaints'];
	$prov_diagnosis=$this  ->popArr['prov_diagnosis'];
	$procedure_presc=$this  ->popArr['procedure_presc'];
	$labtest_presc=$this  ->popArr['labtest_presc'];
	$medicine_presc=$this  ->popArr['medicine_presc'];
	$physical_examination=$this  ->popArr['physical_examination'];
	$allergicInfo=$this ->popArr['allergicInfo'];
	$past_history=$this  ->popArr['past_history'];
	$radiology_presc=$this  ->popArr['radiology_presc'];
	$referalInfo=$this  ->popArr['referalInfo'];

	
?>
<div id="content">
   <div class="box box-info">
      
      <div class="box-body" > 
		<div class="some-content-related-div">
          <div id="inner-content-div">
<div align="center" class="DONTPrint"><a href="#" class="print_casesheet btn btn-warning btn-flat" onClick="Print()">PRINT</a></div>
 <?php if(!empty($presenting_complaints)){?>
 
		<h4 class="box-title"><u><?php  echo $lang_presenting_complaints; ?></u></h4>
		
		<?php for($i=0;$i<count($presenting_complaints);$i++){?>
					              
								  <p><?php echo $presenting_complaints[$i][3];?>&nbsp;&nbsp;&nbsp;<?php echo $presenting_complaints[$i][4];?></p>
			          <?php   }
				  
				  }  
				 ?>

 <?php if(!empty($past_history)){?>
 
		<h4 class="box-title"><u><?php  echo $lang_past_history; ?></u></h4>
		
		<?php for($i=0;$i<count($past_history);$i++){?>
					              
								  <p><?php echo $past_history[$i][4];?></p>
			          <?php   }
				  
				  }  
				 ?>	


		<?php if(!empty($patientInfo[0][89])){?>
		
      
		 <h4 class="box-title"><u><?php echo ucwords(strtolower('EXAMINATION FINDINGS'));?></u></h4>
			           
		
					              
								  <p><?php echo $patientInfo[0][89];?></p>
			          <?php   
				  
				  }  
				 ?>

	<?php if(!empty($procedure_presc)){?>
		
       
		<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_procedure));?></u></h4>
	<?php			           
	  for($i=0;$i<count($procedure_presc);$i++){?>
					              
								  <p><?php echo $procedure_presc[$i][4];?></p>
			          <?php   }
				  
				  }  
				 ?>	
	 <?php if(!empty($labtest_presc)){ ?>	
		
	<?php if(!empty($radiology_presc)){?>
		
       
		<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_radiology));?></u></h4>
	<?php			           
	  for($i=0;$i<count($radiology_presc);$i++){?>
					              
								  <p><?php echo $radiology_presc[$i][4];?></p>
			          <?php   }
				  
				  }  
				 ?>
		
		<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_lab))." ".ucfirst(strtolower($lang_test));?></u></h4>
		<?php
				           for($i=0;$i<count($labtest_presc);$i++){?>
					              
								  <p><?php echo $labtest_presc[$i][4];?></p>
			          <?php   }
				  
				  }  
				 ?>
		
	<?php if(!empty($prov_diagnosis)){?>
		
      
		 <h4 class="box-title"><u><?php  echo $lang_diagnosis; ?></u></h4>
		<?php		           
		for($i=0;$i<count($prov_diagnosis);$i++){?>
					              
								  <p><?php echo $prov_diagnosis[$i][3];?></p>
			          <?php   }
				  
				  }  
				 ?>
		

		

		
	 <?php if(!empty($medicine_presc)){?>
		
       
		<h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_medicine_prescription));?></u></h4>
		 <?php
				           for($i=0;$i<count($medicine_presc);$i++){?>
					              
								  <p><?php echo $medicine_presc[$i][4];?>
										&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$i][5];?>
										&nbsp;&nbsp;&nbsp;<?php echo $medicine_presc[$i][6];?>			
								</p>
			          <?php   }
				  
				  }  
				 ?>
		
	<?php if(!empty($physical_examination)){ ?>
		
      
		<h4 class="box-title"><u><?php echo $lang_physical_exam;?></u></h4>
		 <table class="table table-striped">
	  
	         <?php if($physical_examination[0][3] !=""){ ?>
	             <tr >
					   
					     <td ><?php echo $lang_temp;?></td><td><?php echo $physical_examination[0][3];?>F</td>
				 </tr>
			 <?php } ?>
			 <?php if($physical_examination[0][4] !=""){ ?>
					 <tr >
						<td><?php echo $lang_pulse;?></td><td><?php echo $physical_examination[0][4];?>bpm</td>
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][5] !=""){ ?>
					 <tr >
						<td><?php echo $lang_bp;?></td><td><?php echo $physical_examination[0][5];?>(mm/hg)</td>
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][6] !=""){ ?>
					 <tr >
						<td ><?php echo $lang_height;?></td><td><?php echo $physical_examination[0][6];?>cm</td>
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][7] !=""){ ?>
					 <tr >
						<td><?php echo $lang_weight;?></td><td><?php echo $physical_examination[0][7];?>kgs</td>
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][8] !=""){ ?>
					 <tr >
						<td><?php echo $lang_bmi;?></td><td><?php echo $physical_examination[0][8];?></td>
					    
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][9] !=""){ ?>
					 <tr >
					   
					     <td><?php echo $lang_resp_rate;?></td><td><?php echo $physical_examination[0][9];?>rpm</td>
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][10] !=""){ ?>
					 <tr >

						<td><?php echo $lang_oxy_saturation;?></td><td><?php echo $physical_examination[0][10];?>%</td>
						
					    
					 </tr>
			 <?php } ?>
			<?php if($physical_examination[0][11] !=""){ ?>
					 <tr>
							 <!--  <td colspan="3"></td>
							  
							</tr>
							<tr>
							  <td colspan="3"><p></p>
							  </td> -->

							  <td><?php echo $lang_gen_condition;?></td><td><?php echo $physical_examination[0][11];?></td>

							 </tr>
				 <?php } ?>
		</table>
		
	<?php } ?>

		 <?php if(!empty($allergicInfo)){ ?>
		
       
		 <h4 class="box-title"><u><?php echo ucfirst(strtolower($lang_allergies));?></u></h4>
		         <table  class="table table-striped" width="25%">
		 <?php
					  
					      $k=1;
				    for($i=0;$i<count($allergicInfo);$i++){?>
					   <tr>
					   <td><?php echo $k++;?>
					   <td><?php echo $allergicInfo[$i][3];?></td>
					    <td ><?php echo $allergicInfo[$i][4];?></td>
					  
					  </tr>
		    
			          <?php   } ?>
					  </table>
				  
		<?php		  }  
				 ?>
		<?php if(!empty($patientInfo[0][55]) && $patientInfo[0][55]!='01-01-1970'){?>
		
      
		 <h4 class="box-title"><u><?php echo ucwords(strtolower($lang_followup_date));?></u></h4>
			           
		
					              
								  <p><?php echo $patientInfo[0][55];?></p>
			          <?php   
				  
				  }  
				 ?>

		<?php if(!empty($patientInfo[0][59])){?>
		
      
		 <h4 class="box-title"><u><?php echo ucwords(strtolower($lang_advice));?></u></h4>
			           
		
					              
								  <p><?php echo $patientInfo[0][59];?></p>
			          <?php   
				  
				  }  
				 ?>
				 
		<?php if(!empty($patientInfo[0][50])){?>
		
      
		 <h4 class="box-title"><u><?php echo ucwords(strtolower($lang_remarks));?></u></h4>
			           
		
					              
								  <p><?php echo $patientInfo[0][50];?></p>
			          <?php   
				  
				  }  
				 ?>

			<?php if(!empty($referalInfo)){?>
		
      
		 	<h4 class="box-title"><u><?php  echo 'Referal Info'; ?></u></h4>
			<?php		       

					for($i=0;$i<count($referalInfo);$i++){?>          
						<p><?php echo 'Refered to '.$referalInfo[$i][9].'';?></p>
			        <?php   }
				  
			}

			?>




		
</div>
</div>
</div>
