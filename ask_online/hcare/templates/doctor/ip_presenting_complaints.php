<script>
	
	  $(document).ready(function() {  	
	  
	         $('#pduration').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addComplaints();
		    }
		  });
		  $('#prov_diag').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addDiagnosis();
		    }
		  });

		  $('#past_history').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addPastHistory();
		    }
		  });		  
		  
		  $('#procedure').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addProcedure();
		    }
		  });
		  $('#lab_test').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addLabtest();
		    }
		  });
		  $('#radiology').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addRadiology();
		    }
		  });
		  $('#med_days').bind('keypress', function(e) {
	            if(e.keyCode==13){
		    
		        addMedicines();
		    }
		  });
		  
		  function addComplaints(){
		  
		    var pcomp=$("#pcomp").val();
		    var pduration=$("#pduration").val();
		    
		    var rowCount = $('#pcomp_count').val();
		   
		  if(pcomp !='' || pduration !=''){  
		    var row_disp="<tr id='trs"+rowCount+"'><td>"+pcomp+"</td><td>"+pduration+"<input type='hidden' name='pcomp_name[]' value='"+pcomp+"' class='pcomp_names'><input type='hidden' name='pduration[]' value='"+pduration+"' class='pdurations'></td><td><a href='#' class='delete_complaints text-red' id=c"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#complaint_heading").css("visibility", "visible");
                   
                    $( "#show_complaints" ).append(row_disp);	
                    $("#pcomp").val('');
                    $("#pduration").val('');	
                    $("#pcomp").focus();
		    rowCount=parseInt(rowCount)+1;
		    $('#pcomp_count').val(rowCount);
                   }else{
                       $("#past_history").focus();
                   }		   
		  }
		  
		   $(document).on('click','.delete_complaints', function() {
		   
		         
			  var res = $(this).attr('id').split("c");
                          var row_number=res[1];
                          $( "#trs"+row_number ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });
		   function addDiagnosis(){
		  
		    var prov_diag=$("#prov_diag").val();
		    
		    
		    var rowCount = $('#prov_diag_count').val();
		   
		  if(prov_diag !=''){  
		    var row_disp="<tr id='dg"+rowCount+"'><td>"+prov_diag+"<input type='hidden' name='prov_diag_arr[]' value='"+prov_diag+"'></td><td><a href='#' class='delete_diagnosis text-red' id=d"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#diagnosis_heading").css("visibility", "visible");
                   
                    $( "#show_diagnosis" ).append(row_disp);	
                    $("#prov_diag").val('');
                  
                    $("#procedures").focus();
		    rowCount=parseInt(rowCount)+1;
		    $('#prov_diag_count').val(rowCount);
                   }else{
                       $("#medicines").focus();
                   }		   
		  }	  
		  
		   $(document).on('click','.delete_diagnosis', function() {
		   
		         
			  var res = $(this).attr('id').split("d");
                          var row_number=res[1];
                          $( "#dg"+row_number ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });


		   function addPastHistory(){
		  
		    var past_history=$("#past_history").val();
		    
		    
		    var rowCount = $('#past_history_count').val();
		   
		  if(past_history !=''){  
		    var row_disp="<tr id='ph"+rowCount+"'><td>"+past_history+"<input type='hidden' name='past_history_arr[]' value='"+past_history+"'></td><td><a href='#' class='delete_past_history text-red' id=p"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		   
		     $("#past_history_heading").css("visibility", "visible");
                   
                    $( "#show_past_history" ).append(row_disp);	
                    $("#past_history").val('');
                  
                    $("#procedures").focus();
		    rowCount=parseInt(rowCount)+1;
		    $('#past_history_count').val(rowCount);
                   }else{
                       $("#procedure").focus();
                   }		   
		  }	

		   $(document).on('click','.delete_past_history', function() {
		   
		         
			  			var res = $(this).attr('id').split("p");

                          var row_number=res[1];


                          $( "#ph"+row_number ).remove();	 
			 
		   });		   
		   
		    function addProcedure(){
		  
		    var procedure=$("#procedure").val();
		    var pid=$("#procedure_hidden").val();
		    
		   
		   
		  if(procedure !='' && pid!=''){  
		    var row_disp="<tr id='pr"+pid+"'><td>"+procedure+"<input type='hidden' name='pid[]' value='"+pid+"' ></td><td><a href='#' class='delete_procedure text-red' id=p"+pid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#procedure_heading").css("visibility", "visible");
                   
                    $( "#show_procedure" ).append(row_disp);	
                    $("#procedure").val('');
                    $("#procedure_hidden").val('');	
                    $("#procedure").focus();
		   
                   }else{
                       $("#radiology").focus();
                   }		   
		  }
		  
		   $(document).on('click','.delete_procedure', function() {
		   
		         
			  var res = $(this).attr('id').split("p");
                          var pid=res[1];
                          $( "#pr"+pid ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });
		   
		   function addLabtest(){
		  
		    var lab_test=$("#lab_test").val();
		    var lid=$("#lab_test_hidden").val();
		    
		   
		   
		  if(lab_test !='' && lid!=''){  
		    var row_disp="<tr id='lt"+lid+"'><td>"+lab_test+"<input type='hidden' name='testid[]' value='"+lid+"' ></td><td><a href='#' class='delete_lab_test text-red' id=l"+lid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#lab_test_heading").css("visibility", "visible");
                   
                    $( "#show_lab_test" ).append(row_disp);	
                    $("#lab_test").val('');
                    $("#lab_test_hidden").val('');	
                    $("#lab_test").focus();
		   
                   }else{
                       $("#prov_diag").focus();
                   }		   
		  }
		  
		   $(document).on('click','.delete_lab_test', function() {
		   
		         
			  var res = $(this).attr('id').split("l");
                          var lid=res[1];
                          $( "#lt"+lid ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });
		   function addMedicines(){
		  
		    var medicines=$("#medicines").val();
		    var mid=$("#medicines_hidden").val();
		    var med_course=$("#med_course").val();
		    var med_days=$("#med_days").val();
		    
			if(mid =='') mid=0;
		   
		   if(mid == 0 ) style_tr="style=background-color:#dd4b39;color:#ffffff'";
		   else style_tr='';
		  if(medicines !=''){  
		    var row_disp="<tr id='med"+mid+"'><td "+style_tr+">"+medicines+"</td><td "+style_tr+">"+med_course+"</td><td "+style_tr+">"+med_days+"<input type='hidden' name='m_course[]' value='"+med_course+"' ><input type='hidden' name='m_days[]' value='"+med_days+"' ><input type='hidden' name='mid[]' value='"+mid+"' ><input type='hidden' name='medicines_name[]' value='"+medicines+"' ></td><td><a href='#' class='delete_medicines text-red' id=m"+mid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#medicine_heading").css("visibility", "visible");
                   
                    $( "#show_medicines" ).append(row_disp);	
                    $("#medicines").val('');
                    $("#medicines_hidden").val('');
                     $("#med_course").val('');
                      $("#med_days").val('');		     
                    $("#medicines").focus();
		   
                   }else{
                       $("#followup_date").focus();
                   }		   
		  }
		  
		   $(document).on('click','.delete_medicines', function() {
		   
		         
			  var res = $(this).attr('id').split("m");
                          var mid=res[1];
                          $( "#med"+mid ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });
		   
		    $("#save").bind('click', function() {
		    
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_ip_case_sheet");
   	                 $("#form").submit();
		    });
		     $(".delete_saved_complaints").bind('click', function() {
		    
		         var res = $(this).attr('id').split("sc");
                          var cid=res[1];
			  var data = 'id='+cid+'&from=ip_presenting_complaints';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#trs_data"+cid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_diagnosis").bind('click', function() {
		    
		         var res = $(this).attr('id').split("pd");
                          var pid=res[1];
			  var data = 'id='+pid+'&from=ip_provisional_diagnosis';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#dg_data"+pid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_procedure").bind('click', function() {
		    
		         var res = $(this).attr('id').split("prd");
                          var pid=res[1];
			  var data = 'id='+pid+'&from=ip_procedure_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#pr_data"+pid ).remove();	
			   });
		      
		    });
		     $(".delete_saved_labtest").bind('click', function() {
		    
		         var res = $(this).attr('id').split("ltd");
                          var lid=res[1];
			  var data = 'id='+lid+'&from=ip_labtest_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#lt_data"+lid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_medicine").bind('click', function() {
		    
		         var res = $(this).attr('id').split("mdc");
                          var mid=res[1];
			  var data = 'id='+mid+'&from=ip_medicine_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#med_data"+mid ).remove();	
			   });
		      
		    });

		    $(".delete_saved_past_history").bind('click', function() {

		    
		         var res = $(this).attr('id').split("ph");
                          var phid=res[1];
			     var data = 'id='+phid+'&from=ip_past_history';

			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#ph_data"+phid ).remove();	
			   });
		      
		    });	

		    $(".delete_saved_radiology").bind('click', function() {
		    
		         var res = $(this).attr('id').split("rd");
                          var rid=res[1];
			  var data = 'id='+rid+'&from=ip_radiology_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_ip_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#rd_data"+rid ).remove();	
			   });
		      
		    });




		    function addRadiology(){
		  
		    var radiology=$("#radiology").val();
		    var rid=$("#radiology_hidden").val();
		    
		   
		   
		  if(radiology !='' && rid!=''){  
		    var row_disp="<tr id='rd"+rid+"'><td>"+radiology+"<input type='hidden' name='rid[]' value='"+rid+"' ></td><td><a href='#' class='delete_radiology text-red' id=r"+rid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#radiology_heading").css("visibility", "visible");
                   
                    $("#show_radiology" ).append(row_disp);	
                    $("#radiology").val('');
                    $("#radiology_hidden").val('');	
                    $("#radiology").focus();
		   
                   }else{
                       $("#lab_test").focus();
                   }		   
		  }
		  
		   $(document).on('click','.delete_radiology', function() {
		   
		         
			  var res = $(this).attr('id').split("r");
                          var rid=res[1];
                          $( "#rd"+rid ).remove();	

                           //var rowCount = $('#show_complaints tr').length;
			  
                           //if(rowcount == '0') { alert(rowCount); $("#complaint_heading").css("visibility", "hidden");	}	   
			 
		   });


			
			
		   
	   });
	</script>
	<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
	<script>
       var $j = jQuery.noConflict();
       $j(document).ready(function() { 
          $j(".copy_medicine").bind('click', function() {
			
			    var presc_id = $(this).attr('id');
				 var data = 'id='+presc_id;
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=get_ip_med_presc_json";
				
			   $j.post(inline_action, data, function (response) {
			   
			   if(response['med_id'] == 0 ) style_tr="style=background-color:#dd4b39;color:#ffffff'";
		      else style_tr='';
			  
			    var medicines=response['med_name'];
		        var mid=response['med_id'];
		        var med_course=response['med_course'];
		        var med_days=response['med_days'];
				
				$( "#medicines" ).val(medicines);
				$( "#med_course" ).val(med_course);
				$( "#med_days" ).val(med_days);
				$( "#medicines_hidden" ).val(mid);
				$( "#med_days" ).focus();
				    /*var row_disp="<tr id='med"+mid+"'><td "+style_tr+">"+medicines+"</td><td "+style_tr+">"+med_course+"</td><td "+style_tr+">"+med_days+"<input type='hidden' name='m_course[]' value='"+med_course+"' ><input type='hidden' name='m_days[]' value='"+med_days+"' ><input type='hidden' name='mid[]' value='"+mid+"' ><input type='hidden' name='medicines_name[]' value='"+medicines+"' ></td><td><a href='#' class='delete_medicines text-red' id=m"+mid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		            $("#medicine_heading").css("visibility", "visible");
                   
                    $( "#show_medicines" ).append(row_disp);*/	
			   }, "json").fail(function(){alert(response)});;;
			});
      });
	  </script>
	  
	   <script>
      $(function () {
	  
	     //Date range picker
            $('#followup_date').datepicker();
		
	  });
	  </script>
	  <style type="text/css">
	  	.new{

    font-size: 12px;
    font-weight: 700;


	  	}
	  	.new1{

    font-size: 9px;
    font-weight: 800;
    padding-left: 10px;

	  	}
		i.fa.fa-plus, i.fa.fa-minus {
		    color: white !important;
		    background: none !important;
		}


	  </style>
	  
<?php
    $casesheetInfo=$this  ->popArr['casesheetInfo'];
	$presenting_complaints=$this  ->popArr['presenting_complaints'];
	$prov_diagnosis=$this  ->popArr['prov_diagnosis'];
	$procedure_presc=$this  ->popArr['procedure_presc'];
	$labtest_presc=$this  ->popArr['labtest_presc'];
	$medicine_presc=$this  ->popArr['medicine_presc'];
	$past_history=$this  ->popArr['past_history'];
	$from_op=$this  ->popArr['from'];
	$radiology_presc=$this  ->popArr['radiology_presc'];
	$patientInfo=$this  ->popArr['patient_info'];
	$visitInfo=$this  ->popArr['visitInfo'];


	$ip_presenting_complaints=$this  ->popArr['ip_presenting_complaints'];
	$ip_prov_diagnosis=$this  ->popArr['ip_prov_diagnosis'];
	$ip_procedure_presc=$this  ->popArr['ip_procedure_presc'];
	$ip_labtest_presc=$this  ->popArr['ip_labtest_presc'];
	$ip_medicine_presc=$this  ->popArr['ip_medicine_presc'];
	$ip_past_history=$this  ->popArr['ip_past_history'];
	$from_op=$this  ->popArr['from'];
	$ip_radiology_presc=$this  ->popArr['ip_radiology_presc'];

	$ip_details=$this  ->popArr['ip_details'];

	
?>

   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo $lang_presenting_complaints;?></td>
				   <td> <input name="pcomp" id="pcomp" type="text" size="25" onKeyUp="ajax_showOptions(this,'get_ip_Complaints',event)" autocomplete="off"  onkeypress="nextField(event.keyCode,pduration)" placeholder="complaints">
                                        <input type="text" name="pduration" id="pduration"  size="7" placeholder="duration" onKeyUp="ajax_showOptions(this,'getDuration',event)" >
					<input type="hidden" name="pcomp_count" id="pcomp_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="pcomp_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>

			    <tr>
				   <td><?php echo $lang_past_history;?></td>
				   <td> <textarea name="past_history" id="past_history" rows="2" cols="35" onkeypress="nextField(event.keyCode,nationality)" placeholder="past history" onKeyUp="ajax_showOptions(this,'get_ip_Pasthistory',event)" ></textarea>              
					<input type="hidden" name="past_history_count" id="past_history_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="pcomp_add"><i class="fa fa-plus"></i></a>-->
						
                    </td>
				</tr>

				 <tr>
				   <td><?php echo ucfirst(strtolower($lang_procedure));?></td>
				   <td> <input name="procedure" id="procedure" type="text" size="30" onKeyUp="ajax_showOptions(this,'getProcedures',event)" autocomplete="off" placeholder="procedure" >
                                         <input type="hidden" id="procedure_hidden" name="procedure_ID" >
					<!--<a href="#" class="btn btn-success btn-flat" id="procedure_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>	



				</tr>

				 <tr>
				   <td><?php echo ucwords(strtolower($lang_radiology));?></td>
				   <td> <input name="radiology" id="radiology" type="text" size="30" onKeyUp="ajax_showOptions(this,'getRadiology',event)" autocomplete="off" placeholder="radiology" >
                   <input type="hidden" id="radiology_hidden" name="radiology_ID" >
					<!--<a href="#" class="btn btn-success btn-flat" id="ltest_add"><i class="fa fa-plus"></i></a>-->
						
                    </td>
				</tr>

				
				 <tr>
				   <td><?php echo ucwords(strtolower($lang_lab." ".$lang_test));?></td>
				   <td> <input name="lab_test" id="lab_test" type="text" size="30" onKeyUp="ajax_showOptions(this,'getLabtest',event)" autocomplete="off" placeholder="lab test"  >
                                       <input type="hidden" id="lab_test_hidden" name="lab_test_ID" >
					<!--<a href="#" class="btn btn-success btn-flat" id="ltest_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>							



				<tr>
				   <td><?php echo $lang_diagnosis;?></td>
				   <td> <textarea name="prov_diag" id="prov_diag" rows="2" cols="35" onkeypress="nextField(event.keyCode,nationality)" placeholder="diagnosis" onKeyUp="ajax_showOptions(this,'get_ip_Diagnosis',event)" ></textarea>
					<input type="hidden" name="prov_diag_count" id="prov_diag_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="prov_diag_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>


				 <tr>
				   <td><?php echo $lang_medicine_prescription;?></td>
				   <td> <input name="medicines" id="medicines" type="text" size="25" onKeyUp="ajax_showOptions(this,'getMedicines',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_course)" placeholder="medicines" >
                       <input type="hidden" id="medicines_hidden" name="medicines_ID" >
				       <input name="med_course" id="med_course" type="text" size="3" onKeyUp="ajax_showOptions(this,'getMedCourse',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_days)" placeholder="course" >
				       <input type="hidden" id="med_course_hidden" name="med_course_ID" >
				       <input name="med_days" id="med_days" type="text" size="3" autocomplete="off" placeholder="duration" onKeyUp="ajax_showOptions(this,'getIpMedDays',event)">
				       <input type="hidden" id="med_days_hidden" name="med_days_ID" >
					<!--<a href="#" class="btn btn-success btn-flat" id="med_presc_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>
				<!-- <tr>
				   <td><?php echo ucwords(strtolower($lang_followup_date));echo $patientInfo[0][55];?></td>
				   <td> <input name="followup_date" id="followup_date" type="text" readonly value="<?php echo (!empty($patientInfo[0][55]) && ($patientInfo[0][55]!='00-00-0000' && $patientInfo[0][55]!='01-01-1970'))?$patientInfo[0][55]:'';?>" size="25" autocomplete="off" onkeypress="nextField(event.keyCode,save)" placeholder="followup date" >
				   </td>
				</tr> -->

				<tr>
				   <td><?php echo ucwords(strtolower($lang_advice));?></td>
				   <td> <textarea name="advice" id="advice" rows="2" cols="35" onkeypress="nextField(event.keyCode,remarks)" placeholder="advice" ><?php echo $ip_details[0][3];?></textarea>
				   </td>
				</tr>

				<tr>
				   <td><?php echo ucwords(strtolower($lang_remarks));?></td>
				   <td> <textarea name="remarks" id="remarks" rows="2" cols="35" onkeypress="nextField(event.keyCode,save)" placeholder="remarks" ><?php echo $ip_details[0][4];?></textarea>
				   </td>
				</tr>
								  
				    <tr>
					<td id="noborder" colspan="2" align="center"><input type="button" id="save"  name="Save" class="btn btn-success" value="Save" class="save"/></td>
				    </tr>
				</tr>
			       </table>
		     </div>
		</div>
	</div>
	 <div class="col-md-3">				 
                 <div class="box box-warning box-solid">
		 
		 <div class="box-header with-border">
		    <?php echo $lang_preview;?>
		    </div>
                
                    <div class="box-body">
		    
		             <!-- presenting complaints---->
			       <table id="show_complaints" class="table table-striped">
		               
		                  <div id="complaint_heading" style="<?php echo !(empty($ip_presenting_complaints))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_presenting_complaints;?></div>
				  <?php if(!empty($ip_presenting_complaints)){
				           for($i=0;$i<count($ip_presenting_complaints);$i++){?>
					   <tr id="trs_data<?php echo $ip_presenting_complaints[$i][0];?>">
					   <td><?php echo $ip_presenting_complaints[$i][3];?></td>
					   <td><?php echo $ip_presenting_complaints[$i][4];?></td>
					   <td><a href='#' class='delete_saved_complaints text-red' id="sc<?php echo $ip_presenting_complaints[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>



				 <!-- past history -->
			       <table id="show_past_history" class="table table-striped">
		               
		                  <div id="past_history_heading" style="<?php echo !(empty($ip_past_history))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_past_history;?></div>
				   <?php if(!empty($ip_past_history)){
				           for($i=0;$i<count($ip_past_history);$i++){?>
					   <tr id="ph_data<?php echo $ip_past_history[$i][0];?>">
					   <td><?php echo $ip_past_history[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_past_history text-red' id="ph<?php echo $ip_past_history[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>		                
				

				 <!-- procedure---->
			       <table id="show_procedure" class="table table-striped">
		               
		                  <div id="procedure_heading" style="<?php echo !(empty($ip_procedure_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_procedure));?></div>
				  <?php if(!empty($ip_procedure_presc)){
				           for($i=0;$i<count($ip_procedure_presc);$i++){?>
					   <tr id="pr_data<?php echo $ip_procedure_presc[$i][0];?>">
					   <td><?php echo $ip_procedure_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_procedure text-red' id="prd<?php echo $ip_procedure_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>

				 <!-- radiology -->
			       <table id="show_radiology" class="table table-striped">
		               
		                  <div id="radiology_heading" style="<?php echo !(empty($ip_radiology_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_radiology));?></div>
				  <?php if(!empty($ip_radiology_presc)){
				           for($i=0;$i<count($ip_radiology_presc);$i++){?>
					   <tr id="rd_data<?php echo $ip_radiology_presc[$i][0];?>">
					   <td><?php echo $ip_radiology_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_radiology text-red' id="rd<?php echo $ip_radiology_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		        </table>


				 <table id="show_lab_test" class="table table-striped">
		               
		                  <div id="lab_test_heading" style="<?php echo !(empty($ip_labtest_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_lab." ".$lang_test));?></div>
		                  <?php if(!empty($ip_labtest_presc)){
				           for($i=0;$i<count($ip_labtest_presc);$i++){?>
					   <tr id="lt_data<?php echo $ip_labtest_presc[$i][0];?>">
					   <td><?php echo $ip_labtest_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_labtest text-red' id="ltd<?php echo $ip_labtest_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				   }
				  ?>
				</table>





				 <!-- provisional diagnosis---->
			       <table id="show_diagnosis" class="table table-striped">
		               
		                  <div id="diagnosis_heading" style="<?php echo !(empty($ip_prov_diagnosis))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_diagnosis;?></div>
				   <?php if(!empty($ip_prov_diagnosis)){
				           for($i=0;$i<count($ip_prov_diagnosis);$i++){?>
					   <tr id="dg_data<?php echo $ip_prov_diagnosis[$i][0];?>">
					   <td><?php echo $ip_prov_diagnosis[$i][3];?></td>					
					   <td><a href='#' class='delete_saved_diagnosis text-red' id="pd<?php echo $ip_prov_diagnosis[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>


				<table id="show_medicines" class="table table-striped">
		               
		                  <div id="medicine_heading" style="<?php echo !(empty($ip_medicine_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_medicine_prescription;?></div>
		                <?php if(!empty($ip_medicine_presc)){
				           for($i=0;$i<count($ip_medicine_presc);$i++){?>
					   <tr id="med_data<?php echo $ip_medicine_presc[$i][0];?>">
					   <td><?php echo $ip_medicine_presc[$i][4];?></td>
                                             <td><?php echo $ip_medicine_presc[$i][5];?></td>
                                              <td><?php echo $ip_medicine_presc[$i][6];?></td>					     
					   <td><a href='#' class='delete_saved_medicine text-red' id="mdc<?php echo $ip_medicine_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				   }
				  ?>
				</table>
		    </div>
		 </div>
	</div>
	<div class="col-md-3">				 
                   <div class="box box-success direct-chat direct-chat-success">
		 
		 <div class="box-header with-border">
		    <b><?php echo $lang_casesheet_history;?></b>
		    </div>
		  <div class="box-body">
		  	   <div class="box box-success box-solid">
                          <div class="box-header with-border">
                             <?php echo $casesheetInfo[6];?> 
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
     

                            	
			  <?php 
			         $pcomplaints=$casesheetInfo[0];
			    
		             // if(!empty($presenting_complaints)){?>



			    <!--    <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_presenting_complaints;?></b></div>
		                  
				  <?php if(!empty($presenting_complaints)){
				           for($i=0;$i<count($presenting_complaints);$i++){?>
					   <tr id="trs_data<?php echo $presenting_complaints[$i][0];?>">
					   <td class="new"><?php echo $presenting_complaints[$i][3];?></td>
					   <td class="new"><?php echo $presenting_complaints[$i][4];?></td> -->
					   <!-- <td class="new1"><?php// echo date('d-m-y',strtotime($presenting_complaints[$i][5]));?></td> -->
			<!-- 		   <td class="new1"><?php echo (!empty($presenting_complaints[$i][5])?date('d-m-y',strtotime($presenting_complaints[$i][5])):'');?></td>			

					
					  </tr>
		    
			          <?php   }
				  
				  }  
		        ?>

				</table> -->
				<div class="box box-solid" style="">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                        	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_presenting_complaints;?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool btn-primary" data-widget="collapse" style="padding-top: 1px;"><i class="fa fa-minus" style="color: white;"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                <table class="table" style="background: white;margin-left: 8px; " >
				          


            
      

				  <?php
				           for($i=0;$i<count($pcomplaints);$i++){?>
					   <tr >
					      <td class="new" width="50%"><?php echo $pcomplaints[$i][3];?></td>
					      <td class="new" width="25%"><?php echo $pcomplaints[$i][4];?></td>
					      <!-- <td class="new1"><?php //echo date('d-m-y',strtotime($pcomplaints[$i][5]));?></td> -->
					      <td class="new1" width="25%"><?php echo (!empty($pcomplaints[$i][5])?date('d-m-y',strtotime($pcomplaints[$i][5])):'');?></td>			

					 </tr>
		    
			          <?php   }?>  
				   </table>
				  
				<?php// }?>
  </div><!-- /.box-body -->
                   </div><!-- /.box -->



			  <?php 
			     $pasthistory=$casesheetInfo[8];

			     
		             //if(!empty($past_history)){?>

  <!--       <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b  style=" font-size: 15px;"><?php echo $lang_past_history;?></b></div>
		                  
				      <?php if(!empty($past_history)){
				           for($i=0;$i<count($past_history);$i++){?>
					   <tr id="ph_data<?php echo $past_history[$i][0];?>">
					   <td class="new"><?php echo $past_history[$i][4];?></td> -->	
					   <!-- <td class="new1"><?php //echo date('d-m-y',strtotime($past_history[$i][5]));?></td> -->
			<!-- 		   <td class="new1"><?php echo (!empty($past_history[$i][5])?date('d-m-y',strtotime($past_history[$i][5])):'');?></td>			

					
                       
					   
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
				</table> -->
				 <div class="box  box-solid" style="background: white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                           	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b  style=" font-size: 15px;"><?php echo $lang_past_history;?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus" ></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                <table class="table" style="background: white;margin-left: 8px;">
				          
				  <?php
				           for($i=0;$i<count($pasthistory);$i++){?>
					   <tr >
					      <td class="new"  width="75%"><?php echo $pasthistory[$i][4];?></td>
					      <!-- <td class="new1"><?php// echo date('d-m-y',strtotime($pasthistory[$i][5]));?></td> -->
					      <td class="new1"  width="25%"><?php echo (!empty($pasthistory[$i][5])?date('d-m-y',strtotime($pasthistory[$i][5])):'');?></td>			

					     
					 </tr>
		    
			          <?php   }?>
				   </table>

				
				<?php //}?>	
    </div><!-- /.box-body -->
                   </div><!-- /.box -->
         
				 <!-- procedure---->
				 
			<?php
			    $procedures=$casesheetInfo[2];
			     
		            // if(!empty($procedure_presc)){?>
	<!-- 	            <table class="table ">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo 'Procedure';?></b></div>
		                  
				  <?php if(!empty($procedure_presc)){
				           for($i=0;$i<count($procedure_presc);$i++){?>
					   <tr id="pr_data<?php echo $procedure_presc[$i][0];?>">
					   <td class="new"><?php echo $procedure_presc[$i][4];?></td> -->
					   <!-- <td class="new1"><?php //echo date('d-m-y',strtotime($procedure_presc[$i][5]));?></td> -->
				<!-- 	   <td class="new1"><?php echo (!empty($procedure_presc[$i][5])?date('d-m-y',strtotime($procedure_presc[$i][5])):'');?></td>			
                       
					   
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
				</table> -->
				 <div class="box  box-solid" style="background: white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                           	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo 'Procedure';?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus" ></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                  <table class="table" style="background: white;margin-left: 8px;">
				  <?php 
				           for($i=0;$i<count($procedures);$i++){?>
					   <tr >
					   <td class="new"  width="75%"><?php echo $procedures[$i][4];?></td>	
					   <!-- <td class="new1"><?php// echo date('d-m-y',strtotime($procedures[$i][5]));?></td> -->
					   <td class="new1"  width="25%"><?php echo (!empty($procedures[$i][5])?date('d-m-y',strtotime($procedures[$i][5])):'');?></td>			


					   </tr>
		    
			          <?php   }?>
				   </table>

				<?php //}?>



                           </div><!-- /.box-body -->
                   </div><!-- /.box -->


				 <!-- radiology -->
				 
			<?php
			    $radiology=$casesheetInfo[9];
			     
		            // if(!empty($radiology_presc)){?>

	  <!--  <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b  style=" font-size: 15px;"><?php echo $lang_radiology;?></b></div>
		                  
				 <?php if(!empty($radiology_presc)){
				           for($i=0;$i<count($radiology_presc);$i++){?>
					   <tr id="rd_data<?php echo $radiology_presc[$i][0];?>">
					   <td class="new"><?php echo $radiology_presc[$i][4];?></td> -->	
					   <!-- <td class="new1"><?php //echo date('d-m-y',strtotime($radiology_presc[$i][5]));?></td> -->
					     <!--  <td class="new1"><?php echo (!empty($radiology_presc[$i][5])?date('d-m-y',strtotime($radiology_presc[$i][5])):'');?></td>			
                       
					

					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
				</table> -->
				 <div class="box box-solid" style="background: white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                             <div class="direct-chat-info clearfix btn-primary" width="100%"><b  style=" font-size: 15px;"><?php echo $lang_radiology;?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" style="padding-top: 1px;"><i class="fa fa-minus" style=""></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                  <table class="table" style="background: white;margin-left: 8px;">
				  <?php 
				           for($i=0;$i<count($radiology);$i++){?>
					   <tr >
					   <td class="new"  width="75%"><?php echo $radiology[$i][4];?></td>		
					      <td class="new1"  width="25%"><?php echo (!empty($radiology[$i][5])?date('d-m-y',strtotime($radiology[$i][5])):'');?></td>			
					   </tr>
		    
			          <?php   }?>
				   </table>
				  
				<?php// }?>


  </div><!-- /.box-body -->
                   </div><!-- /.box -->

                          


				

				<?php							
			    $labtest=$casesheetInfo[3];
			     
		             //if(!empty($labtest_presc)){?>
  <!--      <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo 'Lab Test';?></b></div>
		                  
				 <?php if(!empty($labtest_presc)){
				           for($i=0;$i<count($labtest_presc);$i++){?>
					   <tr id="lt_data<?php echo $labtest_presc[$i][0];?>">
					   <td class="new"><?php echo $labtest_presc[$i][4];?></td>
					   <td class="new1"><?php echo (!empty($labtest_presc[$i][6])?date('d-m-y',strtotime($labtest_presc[$i][6])):'');?></td>

					  
					  </tr>
		    
			          <?php   }
				   }
				  ?>
				</table> -->
				 <div class="box box-solid" style="background: white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                            <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo 'Lab Test';?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" style="padding-top: 1px;"><i class="fa fa-minus" style="color: white;"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                  <table class="table" style="background: white;margin-left: 8px;">
		                  <?php 
				           for($i=0;$i<count($labtest);$i++){  ?>
					   <tr >
					   <td class="new"  width="75%"><?php echo $labtest[$i][4];?></td>			
					   <td class="new1"  width="25%"><?php echo (!empty($labtest[$i][6])?date('d-m-y',strtotime($labtest[$i][6])):'');?></td>			

					  </tr>
		    
			         <?php   }?>
				   </table>

				
				<?php// } ?>


				 
                           </div><!-- /.box-body -->
                   </div><!-- /.box -->

				  <!-- provisional diagnosis---->
				  <?php 
			     $diagnosis=$casesheetInfo[1];
			     
		          //   if(!empty($prov_diagnosis)){?>
        <!--       <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_diagnosis;?></b></div>
		                  
				  <?php if(!empty($prov_diagnosis)){
				           for($i=0;$i<count($prov_diagnosis);$i++){?>
					   <tr id="dg_data<?php echo $prov_diagnosis[$i][0];?>">
					   <td class="new"><?php echo $prov_diagnosis[$i][3];?></td>	
					   <td class="new1"><?php echo (!empty($prov_diagnosis[$i][4])?date('d-m-y',strtotime($prov_diagnosis[$i][4])):'');?></td>

					  
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
				</table> -->
				 <div class="box box-solid" style="background: white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                             <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_diagnosis;?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" style="padding-top: 1px;"><i class="fa fa-minus" style="color: white;"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                 <table class="table" style="background: white;margin-left: 8px;" >
				   <?php 
				           for($i=0;$i<count($diagnosis);$i++){?>
					   <tr>
					      <td class="new"  width="75%"><?php echo $diagnosis[$i][3];?></td>	
					        <td class="new1"  width="25%"><?php echo (!empty($diagnosis[$i][4])?date('d-m-y',strtotime($diagnosis[$i][4])):'');?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				  

				<?php //} ?>


				 </div><!-- /.box-body -->
                   </div><!-- /.box -->

                         

<?php
			    $medicines=$casesheetInfo[4];
			     
		            // if(!empty($medicine_presc)){?>
<!-- 
                <table class="table">
			       	 <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_medicine_prescription;?></b></div>
		                  
				  <?php if(!empty($medicine_presc)){
				           for($i=0;$i<count($medicine_presc);$i++){?>
					   <tr id="med_data<?php echo $medicine_presc[$i][0];?>">
					   <td class="new"><?php echo $medicine_presc[$i][4];?></td>
                                             <td class="new"><?php echo $medicine_presc[$i][5];?></td>
                                              <td class="new"><?php echo $medicine_presc[$i][6];?></td>
					   <td class="new1"><?php echo date('d-m-y',strtotime($medicine_presc[$i][7]));?></td>

                                              <td><a href="#" id="<?php echo $medicine_presc[$i][0];?>" class="copy_medicine">Copy</a></td>						     
					  
					  </tr>
		    
			          <?php   }
				   }
				  ?> -->
				</table>
				 <div class="box box-solid" style="background:white;">
                          <div class="box-header with-border" style="height: 18px;padding-top: 1px;">
                             <div class="direct-chat-info clearfix btn-primary" width="100%"><b style=" font-size: 15px;"><?php echo $lang_medicine_prescription;?></b></div>
                                <div class="box-tools pull-right">
                                	
                                  <button class="btn btn-box-tool" data-widget="collapse" style="padding-top: 1px;"><i class="fa fa-minus" style="color: white;"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
                <table class="table" style="background: white;margin-left: 8px;">
		                <?php 
				           for($i=0;$i<count($medicines);$i++){?>
					   <tr <?php echo ($medicines[$i][3] == 0)?"style=background-color:#dd4b39;color:#ffffff'":"";?>>
					       <td class="new"  width="50%"><?php echo $medicines[$i][4];?></td>	
                                              <td class="new"  width="12%"><?php echo $medicines[$i][5];?></td>	
                                              <td class="new"  width="13%"><?php echo $medicines[$i][6];?></td>	
					        <td class="new1"  width="25%"><?php echo (!empty($medicines[$i][7])?date('d-m-y',strtotime($medicines[$i][7])):'');?></td>					

                                           											  
					   </tr>
		    
			          <?php   }?>
				   </table>

				<?php// } ?>



                           </div><!-- /.box-body -->
                   </div><!-- /.box -->




  
	               </div><!-- /.box-body -->
                   </div><!-- /.box -->
	<input type="hidden" name="from" id="from" value="<?php if (!empty($from_op)) {
		echo $from_op;
	} ?>">
	<input type="hidden" name="ipno" value="<?php echo $patientInfo[0][13]?>">
	<input type="hidden" name="ref_ipno" value="<?php echo $patientInfo[0][65]?>">

	</div>
	</div>
	</div>
