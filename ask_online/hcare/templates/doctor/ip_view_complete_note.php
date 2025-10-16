<script>
	
	  $(document).ready(function() {  	
	
    $('#inner-content-div').slimScroll({
    	// height: '250 px';

        height: '100%';
         // width:'75%';
    });

	   });
	</script>
<style type="text/css">
	
	
</style>	
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
	$details=$this  ->popArr['details'];
	$otInfo=$this  ->popArr['otInfo'];

	
?>
<div id="content col-md-8">
   <div class="box box-info">
      
      <div class="box-body" > 
		<div class="some-content-related-div">
          <div id="inner-content-div">
<!-- <div align="center" class="DONTPrint"><a href="#" class="print_casesheet btn btn-warning btn-flat" onClick="Print()">PRINT</a></div> -->
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
		
	

				  <?php if(!empty($details)){ ?>
		
       
		 <h4 class="box-title"><u><?php echo 'Advice';?></u></h4>
		       
		 <?php
					  
					      $k=1;
				    for($i=0;$i<count($details);$i++){?>
					  
					
					   <p><?php echo $details[$i][3];?></p>
					  
					  
					
		    
			          <?php   } ?>
					


					   <h4 class="box-title"><u><?php echo 'Remarks';?></u></h4>
		         
		 <?php
					  
					      $k=1;
				    for($i=0;$i<count($details);$i++){?>
					  
					   <p><?php echo $details[$i][4];?></p>
					  
					  
					
		    
			          <?php   } ?>
					
				  
		<?php		  }  
				 ?>




			



		
</div>
</div>
</div>
