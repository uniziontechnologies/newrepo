
<?php
	$doctors=$this ->popArr['doctors'];
	$patientInfo=$this ->popArr['patient_info'];
	$referalInfo=$this ->popArr['referalInfo'];

	
?>
<div id="content" style="padding: 0px !important">
   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo "Refering to Doctor";?></td>
				   <td> 
                                       
									<select name="refered_doc" id="refered_doc" style="width: 280px;"  /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($referalInfo) && $referalInfo[0][4]==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else if($doctors[$i][0]!=$_SESSION['emp_id']) {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
						
                    </td>
				</tr>


			         <tr>
				   <td><?php echo "Refer Type";?></td>
				   <td> 
                                       
									<select name="ref_type" id="ref_type" style="width: 280px;" /> 		
										<option value=''>------------------------------</option>
										<option value='CANCEL_REFER' <?php if ( !empty($patientInfo[0][68]) && $patientInfo[0][68]=="CANCEL_REFER" ) {echo "selected";} ?> >CANCEL THIS OP & REFER</option>
										<option value='REFER' <?php if ( !empty($patientInfo[0][68]) && $patientInfo[0][68]=="REFER" ) {echo "selected";} ?> >REFER WITHOUT CANCEL</option>	
									</select>
						
                    </td>
				</tr>

				<tr>
				   <td><?php echo $lang_remarks ;?></td>
				   <td> 
					
				   		<textarea id="remarks" name="remarks" style="width: 280px;height: 40px;"><?php if (!empty($referalInfo[0][5]) ) {echo $referalInfo[0][5];} ?></textarea>
						
                    </td>
				</tr>
				
				    <tr>


				    	<td id="noborder" colspan="2" align="center">
				    		



				    	<?php

				    		if ($patientInfo[0][20]==date("Y-m-d") && empty($referalInfo) ) {?>

				    			<input type="button" id="add_reference"  name="Save" class="btn btn-success" value="Add" class="add_reference"/>

				    		<?php
				    		}


				    	 ?>

				    	<?php

				    		if ( $patientInfo[0][20]==date("Y-m-d") && !empty($referalInfo) ) {?>

				    			<input type="button" id="delete_reference"  name="clear_ref" class="btn btn-danger" value="Clear Ref" class="delete_reference"/>

				    		<?php
				    		}


				    	 ?>






				    	</td>







					
				    </tr>
				</tr>
			       </table>
		     </div>
		</div>
	</div>
</div>


	<input type="hidden" id="refering_doc" name="refering_doc" value="<?php echo(!empty($patientInfo[0][14]))?$patientInfo[0][14]:''; ?>" >
	<input type="hidden" name="hidden_remove" id="hidden_remove" value="">
	<input type="hidden" id="ref_id" name="ref_id" value="<?php echo(!empty($referalInfo[0][0]))?$referalInfo[0][0]:''; ?>" >



<script type="text/javascript">
	
 // function add_referal_id() {
 	
 // 	var doctor_refered = $("#doctor_refered").val();

	// $("#refered_doc_id").val(doctor_refered); 	

 // }

	  $(document).ready(function() {  	
	  
	       $("#add_reference").bind('click', function() {
		    
			   if($("#refered_doc").val() == ""){
				   showDialog('Error','Please Select A Doctor To Refer.','error',2);
			      return false;
			   }else{
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=add_referal_info");
   	             $("#form").submit();
				 return true;
			   }
		  });

          $("#delete_reference").bind('click', function() {
		    
                        
		         var id = $("#ref_id").val();
                        
			  	 $("#hidden_remove").val(id);
				
			  	 $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_referal_info");

   	             $("#form").submit();
		      
		    });	

		  
	   });


</script>