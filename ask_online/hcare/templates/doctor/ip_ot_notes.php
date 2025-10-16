<script>
	
	  $(document).ready(function() {  	
	  
	       $("#add_ot_note").bind('click', function() {
		    
			   if($("#ot_note").val() == ""){
				   showDialog('Error','Please Enter Patient OT notes.','error',2);
			      return false;
			   }else{
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=add_ip_ot_note");
   	             $("#form").submit();
				 return true;
			   }
		  });
          $(".delete_saved_ot_notes").bind('click', function() {
		    
		         var res = $(this).attr('id');
                        
			  var data = 'id='+res;
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_ot_note";
				
			   $.post(inline_action, data, function (response) {
				  $( "#trs_data"+res ).remove();	
			   });
		      
		    });	

           $(".edit_saved_ot_notes").bind('click', function() {

           	  var res  = $(this).attr('id');  
           	  var note = $("#note"+res).val();  
           	  
              $("#oid").val(res); 
              $("#ot_note_update").val(note); 

			   var data = 'id='+res;
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=edit_ip_ot_note");
   	             $("#form").submit();
				 return true;
			 //  }
		  });

	   });
	</script>
	
<?php
	$otInfo=$this ->popArr['otInfo'];
	$Patient_info=$this->popArr['Patient_info'];

?>
<div id="content">
   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			
				<tr>
				   <td><?php echo 'OT NOTE :';?></td>
				   <td> <textarea name="ot_note" id="ot_note" rows="4" cols="45" ></textarea>
					
						
                                   </td>
				</tr>
				
				    <tr>
					<td id="noborder" colspan="2" align="center"><input type="button" id="add_ot_note"  name="Save" class="btn btn-success" value="Add" class="add_ot_note"/></td>
				    </tr>
				</tr>
			       </table>
		     </div>
		</div>
	</div>
</div>
	 <div class="col-md-6">				 
                 <!-- <div class="box box-primary box-solid"> -->
		 
		
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <!-- <table id="show_ot_notes" class="table table-striped" width="100%"> -->
		               
		                 
				  <?php if(!empty($otInfo)){// var_dump($otInfo);
				           for($i=0;$i<count($otInfo);$i++){?>
                       
                       <div class="box box-primary  box-solid">
                          <div class="box-header with-border">
		    <?php// echo 'OT Notes';?>
		   
                             <?php echo date('d-m-Y h:i a',strtotime($otInfo[$i][6])) ;?> 
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">

                         <table class="table table-striped">

					   <tr id="trs_data<?php echo $otInfo[$i][0];?>">
					 
					   <td ><textarea class="form-control" id="note<?php echo $otInfo[$i][0];?>" name="note[]" width="5" style="width: 470px; height: 100px;"><?php echo $otInfo[$i][5];?></textarea><br><span style="font-size: 13px;font-weight: 500; color: green;">
					   	<?php echo $otInfo[$i][9];?>
					   </span> </td>
					
					   <td ><a href='#' class='edit_saved_ot_notes text-green' id="<?php echo $otInfo[$i][0];?>" ><i class='fa fa-edit'></i></a>&nbsp;<a href='#' class='delete_saved_ot_notes text-red' id="<?php echo $otInfo[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					 
					   <td></td>
					  </tr>
		            	   </table>
				<?php //}?>
				
                           </div><!-- /.box-body -->
                   </div><!-- /.box -->
			          <?php   }
				  
				  }  
				 ?>
		                </table>
				<input type="hidden" name="oid" id="oid" value="">
				<input type="hidden" name="ot_note_update" id="ot_note_update" value="">
				
		    </div>
		 </div>
	<!-- </div> -->
