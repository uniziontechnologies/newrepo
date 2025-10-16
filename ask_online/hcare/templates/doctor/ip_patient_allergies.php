<script>
	
	  $(document).ready(function() {  	
	  
	       $("#add_allergy").bind('click', function() {
		    
			   if($("#allergic_to").val() == ""){
				   showDialog('Error','Please Enter Patient Allergic To Details.','error',2);
			      return false;
			   }else{
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=add_ip_patient_allergy");
   	             $("#form").submit();
				 return true;
			   }
		  });
          $(".delete_saved_allergies").bind('click', function() {
		    
		         var res = $(this).attr('id');
                        
			  var data = 'id='+res;
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_patient_allergy";
				
			   $.post(inline_action, data, function (response) {
				  $( "#trs_data"+res ).remove();	
			   });
		      
		    });		  
	   });
	</script>
	
<?php
	$allergicInfo=$this ->popArr['allergicInfo'];
	$Patient_info=$this->popArr['Patient_info'];

?>
<div id="content">
   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo $lang_allergic_to;?></td>
				   <td> <input name="allergic_to" id="allergic_to" type="text" size="25"  autocomplete="off"  onkeypress="nextField(event.keyCode,description)">
                                       
				
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo ucwords(strtolower($lang_description));?></td>
				   <td> <textarea name="description" id="description" rows="2" cols="15" ></textarea>
					
						
                                   </td>
				</tr>
				
				    <tr>
					<td id="noborder" colspan="2" align="center"><input type="button" id="add_allergy"  name="Save" class="btn btn-success" value="Add" class="add_allergy"/></td>
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
		    <?php echo $lang_allergies;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <table id="show_allergies" class="table table-striped" width="25%">
		               
		                 
				  <?php if(!empty($allergicInfo)){
				           for($i=0;$i<count($allergicInfo);$i++){?>
					   <tr id="trs_data<?php echo $allergicInfo[$i][0];?>">
					    <td><a href='#' class='delete_saved_allergies text-red' id="<?php echo $allergicInfo[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  
					   <td><?php echo $allergicInfo[$i][3];?></td>
					   
					    <td ><?php echo $allergicInfo[$i][4];?></td>
					      <td><?php echo  date('d-m-Y h:i a',strtotime($allergicInfo[$i][6]));?></td>
					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>
				
				
		    </div>
		 </div>
	</div>
