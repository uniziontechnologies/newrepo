<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="../../dist/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
<script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ajax -->
<link rel="stylesheet" href="../../dist/css/ajax.css">
<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>
<!-- <script type="text/javascript" src="../../plugins/tinymce/tinymce.min.js">  </script> -->


<link rel="stylesheet" href="../../plugins/select2/select2.min.css">


<script type="text/javascript" src="../../plugins/select2/select2.min.js">
	
</script>



<script>



	 function submitForm(action){
	 	
	 
	 	// alert(action); return false;
	 	if(action == 'SEARCH'){
	 		var type=document.add_ot_schedule_form.patient_type.value;

	 		if((type == "OP" || type == "IP") && (document.add_ot_schedule_form.ref_no.value == '')){
				showDialog('Error','Please Enter Ref No.','error',2);
				return false;
			}else{

	 		var act= document.add_ot_schedule_form.paction.value;

	 		// document.add_ot_schedule_form.paction.value=action;
	 		
	 	 // alert(type);return false;

	 		if(document.add_ot_schedule_form.ref_no.value!='') {
	 		document.add_ot_schedule_form.action="../../lib/controllers/centralController.php?module=Nurse&sub_module=search_patient";
			document.add_ot_schedule_form.submit();
		}
	 	}


	 }else if(action == 'SAVE'){
	 	var type=document.add_ot_schedule_form.patient_type.value;

	 		if((type == "OP" || type == "IP") && (document.add_ot_schedule_form.ref_no.value == '')){
				showDialog('Error','Please Enter Ref No.','error',2);
				return false;
			}else if(document.add_ot_schedule_form.first_name.value == ''){
				showDialog('Error','Please Enter First Name.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.age.value == ''){
				showDialog('Error','Please Enter Age.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.gender.value == ''){
				showDialog('Error','Please Enter Gender.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.mobile_no.value == ''){
				showDialog('Error','Please Enter Mobile No.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_name.value == ''){
				showDialog('Error','Please Enter Surgery Name.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_details.value == ''){
				showDialog('Error','Please Enter Surgery Details.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_strated_date_time.value == ''){
				showDialog('Error','Please Select Surgery Started Date Time.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_ended_date_time.value == ''){
				showDialog('Error','Please Select Surgery Ended Date Time.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_status.value == ''){
				showDialog('Error','Please Select Surgery Status.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.consultant_details_counter.value == 0){
				showDialog('Error','Please Select Doctors.','error',2);
				return false;

			}else{
				document.add_ot_schedule_form.paction.value=action;

			 	document.add_ot_schedule_form.action="../../lib/controllers/centralController.php?module=Nurse&sub_module=save_ot_schedule";
				document.add_ot_schedule_form.submit();

			}

	 	



	 }else if(action == 'EDIT_PAGE'){


	 	var type=document.add_ot_schedule_form.patient_type.value;

	 		if((type == "OP" || type == "IP") && (document.add_ot_schedule_form.ref_no.value == '')){
				showDialog('Error','Please Enter Ref No.','error',2);
				return false;
			}else if(document.add_ot_schedule_form.first_name.value == ''){
				showDialog('Error','Please Enter First Name.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.age.value == ''){
				showDialog('Error','Please Enter Age.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.gender.value == ''){
				showDialog('Error','Please Enter Gender.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.mobile_no.value == ''){
				showDialog('Error','Please Enter Mobile No.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_name.value == ''){
				showDialog('Error','Please Enter Surgery Name.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_details.value == ''){
				showDialog('Error','Please Enter Surgery Details.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_strated_date_time.value == ''){
				showDialog('Error','Please Select Surgery Started Date Time.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_ended_date_time.value == ''){
				showDialog('Error','Please Select Surgery Ended Date Time.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.surgery_status.value == ''){
				showDialog('Error','Please Select Surgery Status.','error',2);
				return false;

			}else if(document.add_ot_schedule_form.row_count.value == 0){
				showDialog('Error','Please Select Doctors.','error',2);
				return false;

			}else{
	 	// alert(11111);

	 	document.add_ot_schedule_form.paction.value=action;

	 	document.add_ot_schedule_form.action="../../lib/controllers/centralController.php?module=Nurse&sub_module=update_ot_schedule";
		document.add_ot_schedule_form.submit();
	}



	 }

	}


	


		function add_new_consultant_details(){

			var a=$("#doctors").val();
			// alert(a);

			var docinfo= $('#doctors :selected').text();
		    var doctorinfo=$( "#doctors" ).val().split("||");
			var doctor_id=doctorinfo[0];
			var doctor_name=doctorinfo[1];
			 // alert(doctor_id);
			 // alert(doctor_name); 

			 var row_count = $("#row_count").val();

			 if (row_count!="") {
		        var counter =row_count;
		    }
		    else{
		        var counter = $("#consultant_details_counter").val();
		    }

			 counter ++;

			 if(doctor_id !=" " && doctor_name == undefined){
			 	var doc_name=doctor_id;

			 	var row_content="<div class='row' id='row"+counter+"'><div class='form-group'><div class='col-xs-6'><input type='text' id='doctor_name"+counter+"' name='doctor_name[]' value='"+doc_name+"' class='form-control' readonly></div><div class='col-xs-1' style='padding-top:7px;'><a href='#'><i class='fa fa-remove text-red delete_row' id='del_"+counter+"'></i></a></div></div><input type='hidden' name='doctor_id[]' class='doctor_id_class' value='0'></div><br>";
					
		   		$( "#doctor_selected" ).append(row_content);
		   
		   }else{

			var row_content="<div class='row' id='row"+counter+"'><div class='form-group'><div class='col-xs-6'><input type='text' id='doctor_name"+counter+"' name='doctor_name[]' value='"+doctor_name+"' class='form-control' readonly></div><div class='col-xs-1' style='padding-top:7px;'><a href='#'><i class='fa fa-remove text-red delete_row' id='del_"+counter+"'></i></a></div></div><input type='hidden' name='doctor_id[]' class='doctor_id_class' value="+doctor_id+"></div><br>";
					
		   $( "#doctor_selected" ).append(row_content);
		}

		$("#consultant_details_counter").val(counter);
		 if (row_count!="") {
	            $("#row_count").val(counter);
	        }


		   
					
		

	}

	$(document).ready(function() { 
		 $(document).on('click','.delete_row', function() {
		 	// alert(11111);
		 		

		        var field_val=$(this).attr('id').split("_");
				var counter=field_val[1];

				
			    $( "#row"+counter ).remove();

			    var row_count = $("#row_count").val();

			    if (row_count!="") {
			        var counter =row_count;
			    }
			    else{
			        var counter = $("#consultant_details_counter").val();
			    }
			   
			    $("#consultant_details_counter").val(--counter);

			    if (row_count!="") {
		       $("#row_count").val(--row_count);
		    }
		});	     
	});
   
</script>

</head>
<body id="frame">
<form name="add_ot_schedule_form" id="add_ot_schedule_form"  method="post" action="" > 

<?php

 

$post=$this  ->popArr['post'];
$doctors_info=$this ->popArr['doctors_info'];
$doctors_list=$this ->popArr['doctors_list'];




?>

 <div  id="content">

<section class="content-header">
          <h1>
          <?php echo $lang_ot_schedule; ?>
       
          </h1>
	   <br>

	   	<table>
	   		<tr>
	   			<td>
	   				Type:&nbsp;
				<select name="patient_type" onkeypress="nextField(event.keyCode,dob)">
				<option value="DIRECT" <?php echo (!empty($post['patient_type']) && $post['patient_type']=='DIRECT')?'selected':''?>><?php echo $lang_direct;?></option>
				<option value="OP" <?php echo (!empty($post['patient_type']) && $post['patient_type']=='OP')?'selected':''?>><?php echo $lang_op;?></option>
				<option value="IP" <?php echo (!empty($post['patient_type']) && $post['patient_type']=='IP')?'selected':''?>><?php echo $lang_ip;?></option>
				</select>&nbsp;
	   			</td>
	   			<td><input name="ref_no" id="ref_no" tabbindex="2"  onkeypress="nextField(event.keyCode,search)" value="<?php echo (!empty($post['ref_no']))?$post['ref_no']:''?>" autocomplete="off" placeholder="Ref No"/>&nbsp;</td>
	   			<td>
	   				<input id="button1" type="button" name="search" class="btn btn-primary btn-sm" value="Search" onclick="return submitForm('SEARCH')"/>
	   			</td>
	   			

	   		</tr>
	   	</table>

	   
	   

        </section>



	 
  <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		 <div class="box box-info">

		 	<div class="box-header with-border">
                       <h3 class="box-title text-bold"><?php echo $lang_patient_details;?></h3>
                    </div>
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					
							
						
							
								<tr>
									<td id="noborder">
								
										<?php echo $lang_first_name; ?> <span id='requiredfield'>*</span> : 
									</td>
									<td id="noborder">
								
										 <input name="first_name" id="first_name" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['first_name']))?$post['first_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">
								
										<?php echo $lang_middle_name; ?> : 
									</td>
									<td id="noborder">
								
										 <input name="middle_name" id="middle_name" tabbindex="2"  onkeypress="nextField(event.keyCode,last_name)" value="<?php echo (!empty($post['middle_name']))?$post['middle_name']:''?>" autocomplete="off"/> 
								 
								</td>
								<td id="noborder">			
								
									<?php echo $lang_last_name; ?>  : 
								</td>
								<td id="noborder">
								
										 <input name="last_name" id="last_name" tabbindex="2"  onkeypress="nextField(event.keyCode,age)" value="<?php echo (!empty($post['last_name']))?$post['last_name']:''?>" autocomplete="off"/> 
								 
							</td>
							
						</tr>
						<tr>
									<td id="noborder">
								
										<?php echo $lang_age; ?> <span id='requiredfield'>*</span> : 
									</td>
									<td id="noborder">
								
										 <input name="age" id="age" tabbindex="2"  onkeypress="nextField(event.keyCode,age_type)" value="<?php echo (!empty($post['age']))?$post['age']:''?>" autocomplete="off" size="2"/> 
										<select name="age_type" onkeypress="nextField(event.keyCode,dob)">
											<option value="Y" <?php echo (!empty($post['age_type']) && $post['age_type']=='Y')?'selected':''?>>Y</option>
											<option value="M" <?php echo (!empty($post['age_type']) && $post['age_type']=='M')?'selected':''?>>M</option>
											<option value="D" <?php echo (!empty($post['age_type']) && $post['age_type']=='D')?'selected':''?>>D</option>
										</select> 
										
										 
										
								</td>

								<td id="noborder">		
										<?php echo $lang_gender; ?> <span id='requiredfield'>*</span> :
							</td>
							<td id="noborder">			
										<select name="gender" onkeypress="nextField(event.keyCode,c_of)">
											<option value="">-----------------------------</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='M')?'selected':''?> value="M">Male</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='F')?'selected':''?> value="F">Female</option>
											<option <?php echo (!empty($post['gender']) && $post['gender']=='O')?'selected':''?> value="O">Other</option>
										</select>

								 
							</td>

							<td id="noborder">							
								
								<?php echo $lang_mobile_no; ?>  : <span id='requiredfield'>*</span>
							</td>
							<td id="noborder">
								
								 <input name="mobile_no" id="mobile_no" tabbindex="2"  onkeypress="nextField(event.keyCode,contact_no)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off"/> 
								 
							</td>
						       
                               
								
								
								
						</tr>
						
                             <tr >

                             	 <td id="noborder">			
								
									<?php echo $lang_address; ?>  : 
								</td>
								<td id="noborder">
								
										<textarea name="address" id="address"  onkeypress="nextField(event.keyCode,mobile_no)" /><?php echo (!empty($post['address']))?$post['address']:''?></textarea> 

										
								 
							</td>
							
							
							
                               
							<td colspan="4"></td>
						</tr>
				
							
						
				</table>
				</div>
			  </div>
				
		


               	<div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title text-bold"><?php echo $lang_surgery_details;?></h3>
                    </div>		
				
				<table  class="table table-striped">
					<tr>

						<td id="noborder">							
								
								<?php echo $lang_surgery_name; ?>  :<span id='requiredfield'>*</span> 
							</td>
							<td id="noborder">
								
								 <input name="surgery_name" id="surgery_name" tabbindex="2"  onkeypress="nextField(event.keyCode,surgery_details)" value="<?php echo (!empty($post['surgery_name']))?$post['surgery_name']:''?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getTheatreProcedure',event)"/> 
								 
							</td>
							<td id="noborder">							
								
								<?php echo $lang_surgery_details; ?>  :<span id='requiredfield'>*</span> 
							</td>
							<td id="noborder">
								
								 <textarea id="surgery_details" name="surgery_details" onkeypress="nextField(event.keyCode,surgery_strated)"><?php echo (!empty($post['surgery_details']))?$post['surgery_details']:''?></textarea>
								 	
								  
								 
							</td>

							<td id="noborder">							
								
								<?php echo $lang_surgery_started; ?>  : <span id='requiredfield'>*</span>
							</td>
							<td id="noborder">
								
								 <input type="datetime-local" name="surgery_strated_date_time" id="surgery_strated_date_time" tabbindex="2"  onkeypress="nextField(event.keyCode,surgery_ended_date_time)" value="<?php echo (!empty($post['surgery_strated_date_time']))?$post['surgery_strated_date_time']:''?>" autocomplete="off"/> 
								 
							</td>
							
						
					</tr>
					<tr>

						
							<td id="noborder">							
								
								<?php echo $lang_surgery_ended; ?>  : <span id='requiredfield'>*</span>
							</td>
							<td id="noborder">
								
								 <input type="datetime-local" name="surgery_ended_date_time" id="surgery_ended_date_time" tabbindex="2"  onkeypress="nextField(event.keyCode,surgery_status)" value="<?php echo (!empty($post['surgery_ended_date_time']))?$post['surgery_ended_date_time']:''?>" autocomplete="off"/> 
								 
							</td>



						

							<td id="noborder">							
								
								<?php echo $lang_surgery_status; ?>  : <span id='requiredfield'>*</span>
							</td>
							<td id="noborder">
								
								 <select name="surgery_status" id="surgery_status" >
								 	<option value="">-------------------------</option>
								 	<option value="1" <?php echo (!empty($post['surgery_status']) && $post['surgery_status']=='1')?'selected':''?>>Success</option>
								 	<option value="2" <?php echo (!empty($post['surgery_status']) && $post['surgery_status']=='2')?'selected':''?>>Failed</option>
								 </select> 
								 
							</td>

							<td id="noborder">							
								
								<?php echo $lang_remarks; ?>  : 
							</td>
							<td id="noborder">
								
								 <textarea id="remarks" name="remarks" onkeypress="nextField(event.keyCode,save)"><?php echo (!empty($post['remarks']))?$post['remarks']:''?></textarea>
								 	
								  
								 
							</td>

							



					</tr>
					<tr>
						
							<!-- <td colspan="4"></td> -->
								<td id="noborder">							
								
								<?php echo $lang_doctors; ?>  :<span id='requiredfield'>*</span> 
							</td>
							<td id="noborder" colspan="3">
								
								 <select id="doctors" name="doctors" class="form-control select2" style="width: 50%;" onchange=" add_new_consultant_details();">
								 	<option>----- Please select doctor  -----</option>
								 		<?php 

											       					if (!empty($doctors_info)) {
											       						
											       						for ($u=0; $u < count($doctors_info) ; $u++) { ?>
											       							
											       							<option value="<?php echo $doctors_info[$u][0]."||".$doctors_info[$u][1]." ".$doctors_info[$u][2]." ".$doctors_info[$u][3]; ?>"><?php echo $doctors_info[$u][1]." ".$doctors_info[$u][2]." ".$doctors_info[$u][3]; ?></option>

											       						<?php
											       						}

											       					}


											       				?>
								 </select> 
								 
							</td>
							<td colspan="2">
								<!-- <div id="consultant_details">

								</div> -->

							</td>

					</tr>
		
					</table>
			</div>

			<div class="row">
                  <!-- left column -->
                 <div class="col-md-8">
                     <div   id="doctor_selected">

                     	

								<?php if(!empty($doctors_list)) { 
								$j=1;
								for ($i=0;$i<count($doctors_list);$i++) {
								
									
									$c=count($doctors_list);?>



									<div class='row' id='row<?php echo $i+1; ?>'><div class='form-group'><div class='col-xs-6'><input type='text' id='doctor_name<?php echo $i+1; ?>' name='doctor_name[]' value='<?php echo $doctors_list[$i][3]; ?>' class='form-control' readonly></div><div class='col-xs-1' style='padding-top:7px;'><a href='#'><i class='fa fa-remove text-red delete_row' id='del_<?php echo $i+1; ?>'></i></a></div></div><input type='hidden' name='doctor_id[]' class='doctor_id_class' value='<?php echo $doctors_list[$i][2]; ?>'></div><br>
									

								
								<?php }
							}

								?>


                     	<input type="hidden" name="counter[]" id="consultant_details_counter" value="0">
						<input type="hidden" name="row_count" id="row_count" value="<?php echo(!empty($doctors_list)?count($doctors_list):''); ?>">

                     </div>
                 </div>
             </div>
             <?php

              if($post['paction']=="EDIT_PAGE"){?>
             	<div class="col-md-12 text-center">

				<input id="update" type="button" name="update" class="btn btn-success" value="Update" onclick="return submitForm('EDIT_PAGE')"/>
			</div>

            <?php } else{?>

	<div class="col-md-12 text-center">

				<input id="save" type="button" name="save" class="btn btn-success" value="Save" onclick="return submitForm('SAVE')"/>
			</div>
		<?php }?>

		
		</div>			
			</section>
			</div>
  <input name="paction" id="paction" type="hidden" value="<?php echo (!empty($post['paction']))?$post['paction']:''?>" /> 
   
 
   <input name="id" id="id" type="hidden" value="<?php echo (!empty($post['id']))?$post['id']:''?>" />
     
    
</form>
<script type="text/javascript">
	$(".select2").select2({
  tags: true
});
</script>
</body>
	</html>
	
