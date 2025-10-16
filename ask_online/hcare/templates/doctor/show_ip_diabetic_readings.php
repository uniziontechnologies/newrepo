<script>
	
	</script>
	<?php
	
	$readingInfo=$this  ->popArr['readingInfo'];
	
	?>

		<br><br>	 
     <div class="box box-danger box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_readings;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <table id="show_allergies" class="table table-striped" width="25%">
		               
					   <tr>
					   
					     <th><?php echo $lang_sugar_level;?></th>
						 <th><?php echo $lang_reading_type;?></th>
						 <th><?php echo $lang_reading_date;?></th>
		                 
				  <?php if(!empty($readingInfo)){
				           for($i=0;$i<count($readingInfo);$i++){?>
					   <tr id="trs_data<?php echo $readingInfo[$i][0];?>">
					   
					   <td><?php echo $readingInfo[$i][2];?>mg/dl</td>
					   <td><?php echo $readingInfo[$i][3];?></td>
					    <td ><?php echo date("d-m-Y",strtotime($readingInfo[$i][4]));?></td>
					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>
				
				
		    </div>
		 </div>
	
