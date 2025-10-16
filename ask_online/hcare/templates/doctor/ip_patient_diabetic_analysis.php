<script>
	
	  $(document).ready(function() {  	
	  
	       $("#add_reading").bind('click', function() {
		    
			   if($("#sugar_level").val() == ""){
				   showDialog('Error','Please Enter Sugar Level Reading.','error',2);
			      return false;
			   }if($("#reading_date").val() == ""){
				   showDialog('Error','Please Enter Reading Date.','error',2);
			      return false;
			   }else{
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=add_ip_diabetic_reading");
   	             $("#form").submit();
				 return true;
			   }
		  });
          $(".delete_readings").bind('click', function() {
		    
		         var res = $(this).attr('id');
                        
			  var data = 'id='+res;
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_diabetic_reading";
				
			   $.post(inline_action, data, function (response) {
				  $( "#trs_data"+res ).remove();	
			   });
		      
		    });		

            // $('#reading_date').datepicker();			
	   });
	</script>
	<?php
	
	$readingInfo=$this  ->popArr['readingInfo'];
	
	?>

<div id="content">
   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo $lang_sugar_level;?></td>
				   <td> <input name="sugar_level" id="sugar_level" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,description)">mg/dl
                                       
				
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo $lang_reading_type;?></td>
				   <td> <input name="reading_type" id="reading_type" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,description)">
                                       
				
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo ucwords(strtolower($lang_reading_date));?></td>
				   <td> <input name="reading_date" id="reading_date" type="datetime-local"  value="" size="30" autocomplete="off" onkeypress="nextField(event.keyCode,save)" style=" width: 235;">
				   </td>
				</tr>
				    <tr>
					<td id="noborder" colspan="2" align="center"><input type="button" id="add_reading"  name="Save" class="btn btn-success" value="Add" class="add_reading"/></td>
				    </tr>
				</tr>
			       </table>
		     </div>
		</div>
	</div>
</div>
	 <div class="col-md-6">				 
                 <div class="box box-danger box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_readings;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <table id="show_allergies" class="table table-striped" width="25%">
		               
					   <tr>
					   <th></th>
					     <th><?php echo $lang_sugar_level;?></th>
						 <th><?php echo $lang_reading_type;?></th>
						 <th><?php echo $lang_reading_date;?></th>
		                 
				  <?php if(!empty($readingInfo)){
				           for($i=0;$i<count($readingInfo);$i++){?>
					   <tr id="trs_data<?php echo $readingInfo[$i][0];?>">
					    <td><a href='#' class='delete_readings text-red' id="<?php echo $readingInfo[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  <td><?php echo $readingInfo[$i][2];?>mg/dl</td>
					   <td><?php echo $readingInfo[$i][3];?></td>
					    <td ><?php echo date("d-m-Y h:i a",strtotime($readingInfo[$i][4]));?></td>
					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>
				
				
		    </div>
		 </div>
	</div>
