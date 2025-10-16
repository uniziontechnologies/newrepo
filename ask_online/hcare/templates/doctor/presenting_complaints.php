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

		    // var row_disp="<tr id='trs"+rowCount+"'><td contenteditable='true'>"+pcomp+"</td><td contenteditable='true'>"+pduration+"<input type='hidden' name='pcomp_name[]' value='"+pcomp+"' class='pcomp_names'><input type='hidden' name='pduration[]' value='"+pduration+"' class='pdurations'></td><td ><a href='#' class='delete_complaints text-red' id=c"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";

		     var row_disp="<tr id='trs"+rowCount+"'><td contenteditable='true' id='pcomp_view&"+rowCount+"' value='"+pcomp+"' class='pcomp_change'>"+pcomp+"</td><input type='hidden' name='pcomp_name[]' value='"+pcomp+"' id='pcomp_real"+rowCount+"'><td contenteditable='true' id='pdur_view&"+rowCount+"' value='"+pduration+"' class='pdur_change' >"+pduration+"<input type='hidden' name='pduration[]' value='"+pduration+"' class='pdurations' id='pdur_real"+rowCount+"'></td><td ><a href='#' class='delete_complaints text-red' id=c"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
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


		   $(document).on('blur','.pcomp_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#pcomp_real"+id_value).val(edited_value);
			  	
			  }
    
			 
		   });

		   $(document).on('blur','.pdur_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#pdur_real"+id_value).val(edited_value);
			  	
			  }
    
			 
		   });


		   function addDiagnosis(){
		  
		    var prov_diag=$("#prov_diag").val();
		    
		    
		    var rowCount = $('#prov_diag_count').val();
		   
		  if(prov_diag !=''){  
		    var row_disp="<tr id='dg"+rowCount+"'><td contenteditable='true' id='prov_diag_view&"+rowCount+"' value='"+prov_diag+"' class='prov_diag_change'>"+prov_diag+"<input type='hidden' name='prov_diag_arr[]' value='"+prov_diag+"' id='prov_diag_real"+rowCount+"'></td><td><a href='#' class='delete_diagnosis text-red' id=d"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
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

		   $(document).on('blur','.prov_diag_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#prov_diag_real"+id_value).val(edited_value);
			  	
			  }
    
			 
		   });

		   function addPastHistory(){
		  
		    var past_history=$("#past_history").val();
		    
		    
		    var rowCount = $('#past_history_count').val();
		   
		  if(past_history !=''){  
		    var row_disp="<tr id='ph"+rowCount+"'><td contenteditable='true' id='past_history_view&"+rowCount+"' value='"+past_history+"' class='past_history_change'>"+past_history+"<input type='hidden' name='past_history_arr[]' value='"+past_history+"' id='past_history_real"+rowCount+"'></td><td><a href='#' class='delete_past_history text-red' id=p"+rowCount+" ><i class='fa fa-remove'></i></a></td></tr>";
		   
		     $("#past_history_heading").css("visibility", "visible");
                   
                    $( "#show_past_history" ).append(row_disp);	
                    $("#past_history").val('');
                  
                    $("#past_history").focus();
		    rowCount=parseInt(rowCount)+1;
		    $('#past_history_count').val(rowCount);
                   }else{
                       $("#examination").focus();
                   }		   
		  }	

		   $(document).on('click','.delete_past_history', function() {
		   
		         
			  			var res = $(this).attr('id').split("p");

                          var row_number=res[1];


                          $( "#ph"+row_number ).remove();	 
			 
		   });		   
		   
		   $(document).on('blur','.past_history_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#past_history_real"+id_value).val(edited_value);
			  	
			  }
    
			 
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

		   	var rowCount = $('#medicines_count').val();
		  
		    var medicines=$("#medicines").val();
		    var mid=$("#medicines_hidden").val();
		    var med_course=$("#med_course").val();
		    var med_days=$("#med_days").val();
		    
			if(mid =='') mid=0;
		   
		   if(mid == 0 ) style_tr="style=background-color:#dd4b39;color:#ffffff'";
		   else style_tr='';
		  if(medicines !=''){  
		    var row_disp="<tr id='med"+mid+"'><td "+style_tr+">"+medicines+"<input type='hidden' name='medicines_name[]' value='"+medicines+"' ></td><td id='med_course_view&"+rowCount+"' contenteditable='true' value='"+med_course+"' class='med_course_change' "+style_tr+">"+med_course+"<input type='hidden' name='m_course[]' value='"+med_course+"' id='med_course_real"+rowCount+"' ></td><td contenteditable='true' id='med_days_view&"+rowCount+"' value='"+med_days+"' class='med_days_change' "+style_tr+">"+med_days+"<input type='hidden' name='m_days[]' value='"+med_days+"' id='med_days_real"+rowCount+"' ><input type='hidden' name='mid[]' value='"+mid+"' ></td><td><a href='#' class='delete_medicines text-red' id=m"+mid+" ><i class='fa fa-remove'></i></a></td></tr>";
		    
		     $("#medicine_heading").css("visibility", "visible");
                   
                    $( "#show_medicines" ).append(row_disp);	
                    $("#medicines").val('');
                    $("#medicines_hidden").val('');
                     $("#med_course").val('');
                      $("#med_days").val('');		     
                    $("#medicines").focus();

		   		    rowCount=parseInt(rowCount)+1;
		    		$('#medicines_count').val(rowCount);

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

		   $(document).on('blur','.med_course_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#med_course_real"+id_value).val(edited_value);
			  	
			  }
    
			 
		   });

		   $(document).on('blur','.med_days_change', function() {
		   
			  var id    = $(this).attr('id').split('&');

			  var id_value = id[1];

			  var value = $(this).attr('value');

			  var edited_value = $(this).closest("td").text();

			  if (edited_value!='') {

			  	$("#med_days_real"+id_value).val(edited_value);
			  	
			  }
    
			 
		   });
		   
		   
		   
		    $("#save").bind('click', function() {
		    
		         $("#form").attr("action","../../lib/controllers/centralController.php?module=Doctor&sub_module=save_case_sheet");
   	                 $("#form").submit();
		    });
		     $(".delete_saved_complaints").bind('click', function() {
		    
		         var res = $(this).attr('id').split("sc");
                          var cid=res[1];
			  var data = 'id='+cid+'&from=presenting_complaints';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#trs_data"+cid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_diagnosis").bind('click', function() {
		    
		         var res = $(this).attr('id').split("pd");
                          var pid=res[1];
			  var data = 'id='+pid+'&from=provisional_diagnosis';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#dg_data"+pid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_procedure").bind('click', function() {
		    
		         var res = $(this).attr('id').split("prd");
                          var pid=res[1];
			  var data = 'id='+pid+'&from=procedure_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#pr_data"+pid ).remove();	
			   });
		      
		    });
		     $(".delete_saved_labtest").bind('click', function() {
		    
		         var res = $(this).attr('id').split("ltd");
                          var lid=res[1];
			  var data = 'id='+lid+'&from=labtest_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#lt_data"+lid ).remove();	
			   });
		      
		    });
		    $(".delete_saved_medicine").bind('click', function() {
		    
		         var res = $(this).attr('id').split("mdc");
                          var mid=res[1];
			  var data = 'id='+mid+'&from=medicine_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#med_data"+mid ).remove();	
			   });
		      
		    });

		    $(".delete_saved_past_history").bind('click', function() {

		    
		         var res = $(this).attr('id').split("ph");
                          var phid=res[1];
			  var data = 'id='+phid+'&from=past_history';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
			   $.post(inline_action, data, function (response) {
				  $( "#ph_data"+phid ).remove();	
			   });
		      
		    });	

		    $(".delete_saved_radiology").bind('click', function() {
		    
		         var res = $(this).attr('id').split("rd");
                          var rid=res[1];
			  var data = 'id='+rid+'&from=radiology_prescribed';
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=delete_casesheet_items";
				
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

		function go_next_line(value) {
    		event.preventDefault();
      		var s = jQuery(value).val();
      		jQuery(value).val(s+"\n");		
		}
		   function addDiagnosisTag(value){

		   	var diagnosis = value.value;
		    var	prov_diag = diagnosis.replace('`','');
		    
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
                   	   $("#prov_diag").val('');
                       $("#medicines").focus();
                   }		   
		  }	

		  function addComplaintsTag(value){
		  

		    var pcomp=$("#pcomp").val();
		    var pduration=$("#pduration").val();

		    var	pduration = pduration.replace('`','');
		    
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

		  function goToPduration(value){

		   	var complaints = value.value;
		    var	complaints = complaints.replace('`','');

		    $("#pcomp").val(complaints);
		    $("#pduration").focus();

		  }


	</script>
	<script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
	<script>
       var $j = jQuery.noConflict();
       $j(document).ready(function() { 
          $j(".copy_medicine").bind('click', function() {
			
			    var presc_id = $(this).attr('id');
				 var data = 'id='+presc_id;
				
			  inline_action="../../lib/controllers/centralController.php?module=Doctor&sub_module=get_med_presc_json";
				
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


	
?>

   <div class="box box-info">
                
                     <div class="box-body">
			       <table class="table">
			         <tr>
				   <td><?php echo $lang_presenting_complaints;?></td>

				   <td> <input name="pcomp" id="pcomp" type="text" size="25" onkeyup="if (event.keyCode==192) {goToPduration(this);}else{ajax_showOptions(this,'getComplaints',event)}" autocomplete="off"  onkeypress="nextField(event.keyCode,pduration)" placeholder="complaints">

                                        <input type="text" name="pduration" id="pduration"  size="7" placeholder="duration" onkeyup="if (event.keyCode==192) {addComplaintsTag(this);}else{ajax_showOptions(this,'getDuration',event)}" autocomplete="off" >
					<input type="hidden" name="pcomp_count" id="pcomp_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="pcomp_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>

			    <tr>
				   <td><?php echo $lang_past_history;?></td>
				   <td> <textarea name="past_history" id="past_history" rows="2" cols="35" onkeypress="nextField(event.keyCode,examination)" placeholder="past history" onKeyUp="ajax_showOptions(this,'getPasthistory',event)" ></textarea>              
					<input type="hidden" name="past_history_count" id="past_history_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="pcomp_add"><i class="fa fa-plus"></i></a>-->
						
                    </td>
				</tr>


				<tr>
				   <td><?php echo 'Examination Findings';?></td>
				   <td> <textarea name="examination" id="examination" rows="2" cols="35" onkeypress="nextField(event.keyCode,procedure)" placeholder="examination findings" onKeyUp="ajax_showOptions(this,'getExamination',event)"><?php echo $patientInfo[0][89] ;?></textarea>
				   	<input type="hidden" id="examination_hidden" name="examination_ID" >
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
				   <td> <textarea name="prov_diag" id="prov_diag" rows="2" cols="35" onkeypress="nextField(event.keyCode,nationality)" placeholder="diagnosis" onkeyup="if (event.keyCode==192) {addDiagnosisTag(this);}else{ajax_showOptions(this,'getDiagnosis',event)}" ></textarea>
					<input type="hidden" name="prov_diag_count" id="prov_diag_count" value="0">
					<!--<a href="#" class="btn btn-success btn-flat" id="prov_diag_add"><i class="fa fa-plus"></i></a>-->
						
                                   </td>
				</tr>


				 <tr>
				   <td><?php echo $lang_medicine_prescription;?></td>
				   <td> <input name="medicines" id="medicines" type="text" size="24" onKeyUp="ajax_showOptions(this,'getMedicines',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_course)" placeholder="medicines" >
                       <input type="hidden" id="medicines_hidden" name="medicines_ID" >
				       <input name="med_course" id="med_course" type="text" size="3" onKeyUp="ajax_showOptions(this,'getMedCourse',event)" autocomplete="off" onkeypress="nextField(event.keyCode,med_days)" placeholder="course" >
				       <input type="hidden" id="med_course_hidden" name="med_course_ID" >
				       <input name="med_days" id="med_days" type="text" size="3" autocomplete="off" placeholder="days" onKeyUp="ajax_showOptions(this,'getMedDays',event)">
				       <input type="hidden" id="med_days_hidden" name="med_days_ID" >
					<!--<a href="#" class="btn btn-success btn-flat" id="med_presc_add"><i class="fa fa-plus"></i></a>-->
					<input type="hidden" name="medicines_count" id="medicines_count" value="0">
						
                                   </td>
				</tr>
				<tr>
				   <td><?php echo ucwords(strtolower($lang_followup_date));echo $patientInfo[0][55];?></td>
				   <td> <input name="followup_date" id="followup_date" type="text" readonly value="<?php echo (!empty($patientInfo[0][55]) && ($patientInfo[0][55]!='00-00-0000' && $patientInfo[0][55]!='01-01-1970'))?$patientInfo[0][55]:'';?>" size="25" autocomplete="off" onkeypress="nextField(event.keyCode,save)" placeholder="followup date" >
				   </td>
				</tr>

				<tr>
				   <td><?php echo ucwords(strtolower($lang_advice));?></td>
				   <td> <textarea name="advice" id="advice" rows="2" cols="35" onkeypress="if(event.keyCode== 13){return go_next_line(this);}" placeholder="advice" onKeyUp="ajax_showOptions(this,'getAdvice',event)" ><?php echo $patientInfo[0][88];?></textarea>
				   </td>
				</tr>

				<tr>
				   <td><?php echo ucwords(strtolower($lang_remarks));?></td>
				   <td> <textarea name="remarks" id="remarks" rows="2" cols="35" onkeypress="nextField(event.keyCode,save)" placeholder="remarks" ><?php echo $patientInfo[0][50];?></textarea>
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
		               
		                  <div id="complaint_heading" style="<?php echo !(empty($presenting_complaints))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_presenting_complaints;?></div>
				  <?php if(!empty($presenting_complaints)){
				           for($i=0;$i<count($presenting_complaints);$i++){?>
					   <tr id="trs_data<?php echo $presenting_complaints[$i][0];?>">
					   <td><?php echo $presenting_complaints[$i][3];?></td>
					   <td><?php echo $presenting_complaints[$i][4];?></td>
					   <td><a href='#' class='delete_saved_complaints text-red' id="sc<?php echo $presenting_complaints[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>



				 <!-- past history -->
			       <table id="show_past_history" class="table table-striped">
		               
		                  <div id="past_history_heading" style="<?php echo !(empty($past_history))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_past_history;?></div>
				   <?php if(!empty($past_history)){
				           for($i=0;$i<count($past_history);$i++){?>
					   <tr id="ph_data<?php echo $past_history[$i][0];?>">
					   <td><?php echo $past_history[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_past_history text-red' id="ph<?php echo $past_history[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>		                
				

				 <!-- procedure---->
			       <table id="show_procedure" class="table table-striped">
		               
		                  <div id="procedure_heading" style="<?php echo !(empty($procedure_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_procedure));?></div>
				  <?php if(!empty($procedure_presc)){
				           for($i=0;$i<count($procedure_presc);$i++){?>
					   <tr id="pr_data<?php echo $procedure_presc[$i][0];?>">
					   <td><?php echo $procedure_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_procedure text-red' id="prd<?php echo $procedure_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>

				 <!-- radiology -->
			       <table id="show_radiology" class="table table-striped">
		               
		                  <div id="radiology_heading" style="<?php echo !(empty($radiology_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_radiology));?></div>
				  <?php if(!empty($radiology_presc)){
				           for($i=0;$i<count($radiology_presc);$i++){?>
					   <tr id="rd_data<?php echo $radiology_presc[$i][0];?>">
					   <td><?php echo $radiology_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_radiology text-red' id="rd<?php echo $radiology_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		        </table>


				 <table id="show_lab_test" class="table table-striped">
		               
		                  <div id="lab_test_heading" style="<?php echo !(empty($labtest_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_lab." ".$lang_test));?></div>
		                  <?php if(!empty($labtest_presc)){
				           for($i=0;$i<count($labtest_presc);$i++){?>
					   <tr id="lt_data<?php echo $labtest_presc[$i][0];?>">
					   <td><?php echo $labtest_presc[$i][4];?></td>					
					   <td><a href='#' class='delete_saved_labtest text-red' id="ltd<?php echo $labtest_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				   }
				  ?>
				</table>





				 <!-- provisional diagnosis---->
			       <table id="show_diagnosis" class="table table-striped">
		               
		                  <div id="diagnosis_heading" style="<?php echo !(empty($prov_diagnosis))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_diagnosis;?></div>
				   <?php if(!empty($prov_diagnosis)){
				           for($i=0;$i<count($prov_diagnosis);$i++){?>
					   <tr id="dg_data<?php echo $prov_diagnosis[$i][0];?>">
					   <td><?php echo $prov_diagnosis[$i][3];?></td>					
					   <td><a href='#' class='delete_saved_diagnosis text-red' id="pd<?php echo $prov_diagnosis[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
					  </tr>
		    
			          <?php   }
				  
				  }  
				 ?>
		                </table>


				<table id="show_medicines" class="table table-striped">
		               
		                  <div id="medicine_heading" style="<?php echo !(empty($medicine_presc))?'visibility:visible':'visibility:hidden';?>" class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_medicine_prescription;?></div>
		                <?php if(!empty($medicine_presc)){
				           for($i=0;$i<count($medicine_presc);$i++){?>
					   <tr id="med_data<?php echo $medicine_presc[$i][0];?>">
					   <td><?php echo $medicine_presc[$i][4];?></td>
                                             <td><?php echo $medicine_presc[$i][5];?></td>
                                              <td><?php echo $medicine_presc[$i][6];?></td>					     
					   <td><a href='#' class='delete_saved_medicine text-red' id="mdc<?php echo $medicine_presc[$i][0];?>" ><i class='fa fa-remove'></i></a></td>
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
            <?php if(!empty($casesheetInfo)){

                    for($k=0;$k<count($casesheetInfo);$k++){
		    
		     	    
		    
		    ?>	    
                       <div class="box box-success collapsed-box box-solid">
                          <div class="box-header with-border">
                             <?php echo $casesheetInfo[$k][6];?> 
                                <div class="box-tools pull-right">
                                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                 </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                            <div class="box-body">
			    
                                <!-- presenting complaints---->
			  <?php 
			     $pcomplaints=$casesheetInfo[$k][0];
			     
		             if(!empty($pcomplaints)){?>
			       <table class="table table-striped">
		                  
				 
				           <div class="direct-chat-info clearfix btn-warning" width="100%"><b><?php echo $lang_presenting_complaints;?></b></div>
				  <?php
				           for($i=0;$i<count($pcomplaints);$i++){?>
					   <tr >
					      <td><?php echo $pcomplaints[$i][3];?></td>
					      <td><?php echo $pcomplaints[$i][4];?></td>
					 </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>


			  <?php 
			     $pasthistory=$casesheetInfo[$k][8];

			     
		             if(!empty($pasthistory)){?>
			       <table class="table table-striped">
		                  
				 
				           <div class="direct-chat-info clearfix btn-warning" width="100%"><b><?php echo $lang_past_history;?></b></div>
				  <?php
				           for($i=0;$i<count($pasthistory);$i++){?>
					   <tr >
					      <td><?php echo $pasthistory[$i][4];?></td>
					     
					 </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>	

				 <!-- procedure---->
				 
			<?php
			    $procedures=$casesheetInfo[$k][2];
			     
		             if(!empty($procedures)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_procedure));?></div>
				  <?php 
				           for($i=0;$i<count($procedures);$i++){?>
					   <tr >
					   <td><?php echo $procedures[$i][4];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>


				 <!-- radiology -->
				 
			<?php
			    $radiology=$casesheetInfo[$k][9];
			     
		             if(!empty($radiology)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_radiology));?></div>
				  <?php 
				           for($i=0;$i<count($radiology);$i++){?>
					   <tr >
					   <td><?php echo $radiology[$i][4];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }?>

				

				<?php							
			    $labtest=$casesheetInfo[$k][3];
			     
		             if(!empty($labtest)){?>
				 <table  class="table table-striped">
		               
		                  <div class="direct-chat-info clearfix btn-warning" width="100%"><?php echo ucwords(strtolower($lang_lab." ".$lang_test));?></div>
		                  <?php 
				           for($i=0;$i<count($labtest);$i++){?>
					   <tr >
					   <td><?php echo $labtest[$i][4];?></td>					
					  </tr>
		    
			         <?php   }?>
				   </table>
				<?php } ?>


				
				 

				  <!-- provisional diagnosis---->
				  <?php 
			     $diagnosis=$casesheetInfo[$k][1];
			     
		             if(!empty($diagnosis)){?>
			       <table class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_provisional_diagnosis;?></div>
				   <?php 
				           for($i=0;$i<count($diagnosis);$i++){?>
					   <tr>
					      <td><?php echo $diagnosis[$i][3];?></td>					
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php }


				

			    $medicines=$casesheetInfo[$k][4];
			     
		             if(!empty($medicines)){?>
				<table  class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_medicine_prescription;?></div>
		                <?php 
				           for($i=0;$i<count($medicines);$i++){?>
					   <tr <?php echo ($medicines[$i][3] == 0)?"style=background-color:#dd4b39;color:#ffffff'":"";?>>
					       <td><?php echo $medicines[$i][4];?></td>	
                                              <td><?php echo $medicines[$i][5];?></td>	
                                              <td><?php echo $medicines[$i][6];?></td>	
                                              <td><a href="#" id="<?php echo $medicines[$i][0];?>" class="copy_medicine">Copy</a></td>												  
					   </tr>
		    
			          <?php   }?>
				   </table>
				<?php } ?>


				<?php
			       $advice=$casesheetInfo[$k][10];
			     
		             if(!empty($advice)){?>
			     <table  class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_advice;?></div>
		              
					   <tr >
					       <td><?php echo $advice;?></td>					
					   </tr>
		    
			         
				</table>
				<?php }

				  ?>
				

				<?php
			       $remarks=$casesheetInfo[$k][7];
			     
		             if(!empty($remarks)){?>
			     <table  class="table table-striped">
		               
		                  <div  class="direct-chat-info clearfix btn-warning" width="100%"><?php echo $lang_remarks;?></div>
		              
					   <tr >
					       <td><?php echo $remarks;?></td>					
					   </tr>
		    
			         
				</table>
				<?php } ?>

                           </div><!-- /.box-body -->
                   </div><!-- /.box -->
	<?php  }
	     }
	?>
	<input type="hidden" name="from" id="from" value="<?php if (!empty($from_op)) {
		echo $from_op;
	} ?>">
	</div>
	</div>
	</div>
