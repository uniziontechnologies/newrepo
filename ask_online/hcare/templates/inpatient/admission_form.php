<?php
require_once ROOT_PATH . '/lib/common/commonFunctions.php';

$commObj= new CommonFunctions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $lang_title; ?></title>



   <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	
	<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
	
	<link rel="stylesheet" href="../../dist/css/ajax.css">
	<link rel="stylesheet" type="text/css" href="../../dist/css/dialog_box.css" />
	


 <script src="../../plugins/jQuery/jquery-1.2.6.min.js"></script>
 <!-- <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script> -->

 <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
 <script type="text/javascript" src="../../dist/js/dialog_box.js"></script>
<script type="text/javascript" src="../../dist/js/common_functions.js"></script>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../ajax/ajax-dynamic-list.js"></script>




<script>

	// $(function () {
  //       //Initialize Select2 Elements
  //       $(".select2").select2();

  //  });

	// $(function () {
	  
	//    //Date range picker
  //       $('#date_issue').datepicker();
	// 	 $('#date_expiry').datepicker();
	//   });
   
   
     function submitForm(){
   		
		d = new Date();
		today=d.getDate()+"-"+d.getMonth()+"-"+d.getFullYear();
		
		
		
   		if(document.admission.first_name.value=='') {
   			showDialog('Error','Please Enter Patient  Name.','error',2);
			return false;
			
		}else if(document.admission.age.value=='' || !(isNumeric(document.admission.age.value))) {
		
   			showDialog('Error','Please Enter Patient  Age.','error',2);
			return false;
			
		}else if(document.admission.gender.value=='') {
		
   			showDialog('Error','Please Select Patient  Gender.','error',2);
			return false;
			
		}else if(document.admission.place.value=='') {
		
   			showDialog('Error','Please Select Patient  Place.','error',2);
			return false;
			
		}else if(document.admission.contact_no.value!='' && !(isNumeric(document.admission.contact_no.value))) {
		
   			showDialog('Error','Please Enter Numeric Values For Contact Number.','error',2);
			return false;
			
		}else if(document.admission.email.value!='' && !(validateEmail(document.admission.email.value))) {
		
   			showDialog('Error','Please Enter Valid Email.','error',2);
			return false;
			
		}else if(document.admission.doctor.value=='') {
		
   			showDialog('Error','Please Select Doctor.','error',2);
			return false;
			
		}else if( document.admission.room.value=='' && document.admission.paction.value == 'SAVE') {
		
   			showDialog('Error','Please Select Room No.','error',2);
			return false;
			
		}else if(document.admission.insurance_company.value !='' && document.admission.date_issue.value!='' && document.admission.date_issue.value > today){
		
				showDialog('Error','You Entered An Invlid Issue date.','error',2);
				return false;
		
		}else if(document.admission.insurance_company.value !='' && document.admission.date_expiry.value!='' && document.admission.date_expiry.value < today ){
		
				showDialog('Error','You Entered An Invlid Expiry date.','error',2);
				return false;
		
		}else {
			document.admission.action="../../lib/controllers/centralController.php?module=IP&sub_module=patient_admission";
			document.admission.submit();
			return true;
		
		}
	}
	
	
	
	$(document).ready(function() { 


          
			
			$("#room").change( function(){
			
			 var room_id=$("#room").val();
			 
			 
			 	var data = 'id='+room_id;
				
				inline_action="../../lib/controllers/centralController.php?module=IP&sub_module=process_room";
				
				 $.post(inline_action, data, function (response) {
				 
				 	var bedInfo=response['bedInfo'];
					
					$("#bed_no option").remove();
						for(i=0;i<bedInfo.length;i++){
						
							$("#bed_no").append("<option value='"+bedInfo[i][0]+"'>"+bedInfo[i][1]+" </option>");
						
						}
					
				 $("#rent").val(response['room_rent']);
				  $("#ncharge").val(response['ncharges']);
				   $("#mcharge").val(response['mcharges']);
				   $("#bcharge").val(response['bcharges']);
				 },"json");
			
			});
                      
			
        });
</script>

</head>
<body id="frame">
<form name="admission" id="form"  method="post" action="" enctype="multipart/form-data" onload="initailize();"> 

<?php

 
$action=$this->popArr['action'];
$status = $this->popArr['status'];



$doctors=$this->popArr['doctors'];
$countries=$this->popArr['countries'];
$departments=$this->popArr['departments'];
$roomInfo=$this->popArr['roomInfo'];
$observation=$this->popArr['observation'];

if(isset($this->popArr['post'])){
	
	$post=$this->popArr['post'];
	//if(!empty($this->popArr['message'])) $opno_status="active";
	//else $opno_status="hide";
	$inc_company=$post['inc_company'];

	$pat_cat_list=$post['pat_cat_list'];

	
}else{
	//$opno_status="active";
}

if(!empty($post['opno'])){
	
	$opno_status = "hide";
}else $opno_status = "active";


?>
 <div  id="content">
<section class="content-header">
          <h1>
          <?php echo $lang_admission; ?>
       
          </h1>
	  <?php if($post['id'] != ""){?>
          <ol class="breadcrumb"> 
	                                        <?php						
						if(file_exists("../../templates/registration/patient_photo/".$post['opno']."/photo.jpg")){
						?>
						
						<img src="../../templates/registration/patient_photo/<?php echo $post['opno'];?>/photo.jpg" width="80" height="80">
						<?php
						 }else{						
						?>
						<img src="../../templates/registration/patient_photo/testimage.jpg" width="80px" height="80px">
						<?php } ?>
				
           
          </ol><br><br> <br>
  <?php } ?>
        </section>	 
  <section class="content">
          <?php if(isset($this->popArr['message'])){?>
					<br /><br />
						<div id='message'><?php echo $this->popArr['message'];?></div>
		<?php } ?>
		 <div class="box box-info">
                
               <div class="box-body">
			    <table width="100%" class="table table-striped">
					
								<tr>
								
								  <td id="noborder" colspan="3" align="center">
										<input name="ipno" id="ipno" type="hidden" value="<?php echo (!empty($post['ipno']))?$post['ipno']:''?>" />
									
										<b><?php echo $lang_ip_no; ?> :<?php echo (!empty($post['ipno']))?$post['ipno']:''?></b>
									</td>
									
									<td id="noborder" colspan="3" align="center">
										<input name="opno" id="opno" type="hidden" value="<?php echo (!empty($post['opno']))?$post['opno']:''?>" />
									
										<b><?php echo $lang_op_no; ?> :<?php echo (!empty($post['opno']))?$post['opno']:''?></b>
									</td>
								</tr>
							<tr>
					              <td id="noborder">
					                    <?php echo $lang_patient_category; ?>
					              </td>	
					              <td id="noborder">
                                      <select disabled>
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($pat_cat_list);$i++){ 
																						
													if(!empty($post['patient_category']) && $post['patient_category']==$pat_cat_list[$i][0]) { ?>
													
														<option value='<?php echo $pat_cat_list[$i][0];?>' selected <?php if($patient_category[$i][2]=='YES'){?> class="member_option" <?php }?>><?php echo $pat_cat_list[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $pat_cat_list[$i][0];?>' <?php if($patient_category[$i][2]=='YES'){?> class="member_option" <?php }?>><?php echo  $pat_cat_list[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select> 
									<input type="hidden" name="patient_category" id="patient_category" tabbindex="2"  onkeypress="nextField(event.keyCode,middle_name)" value="<?php echo (!empty($post['patient_category']))?$post['patient_category']:''?>" autocomplete="off"/> 
									<?php 
										if($post['member_patient_id_name']){
												echo 'Member ID : '.$post['member_patient_id_name'];
										}
									
										// if($post['member_name']){
										// 		echo '&nbsp;&nbsp;&nbsp;Member : '.$post['member_name'];
										// }
									?> 
                                  </td>	    	
				            </tr>
							
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
										<?php echo $lang_dob; ?>
										 
									</td>
									<td id="noborder">
								
										 <input type="text" name="dob" id="dob" value="<?php echo (!empty($post['dob']))?$post['dob']:''?>" autocomplete="off"   class="date_cal" onkeypress="nextField(event.keyCode,marital_status)" readonly="true"/>
								 
								</td>
								<td id="noborder">			
								
									<?php echo $lang_marital_status; ?>  : 
								</td>
								<td id="noborder">
								
										 <select name="marital_status" id="marital_status"  onkeypress="nextField(event.keyCode,gender)">
											<option value="">-----------------------------</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Single')?'selected':''?> value="Single">Single</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Married')?'selected':''?> value="Married">Married</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Widow')?'selected':''?> value="Widow">Widow</option>
											<option <?php echo (!empty($post['marital_status']) && $post['marital_status']=='Divorced')?'selected':''?> value="Divorced">Divorced</option>
										</select> 
								</td>
						</tr>
						<tr>
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
								
									<?php echo $lang_care_of; ?>  : 
								</td>
								<td id="noborder">
								
										 <input name="c_of" id="c_of" tabbindex="2"  onkeypress="nextField(event.keyCode,address)" value="<?php echo (!empty($post['c_of']))?$post['c_of']:''?>" autocomplete="off"/> 
								 
							</td>
                                                         <td id="noborder">			
								
									<?php echo $lang_address; ?>  : 
								</td>
								<td id="noborder">
								
										 <textarea name="address" id="address"  onkeypress="nextField(event.keyCode,place)" /> <?php echo (!empty($post['address']))?$post['address']:''?></textarea>
								 
							</td>
                                               </tr>
                                              <tr>
							<td id="noborder">							
								
								<?php echo $lang_place; ?><span id='requiredfield'>*</span> : 
							</td>
							<td id="noborder">								
								 <input type="text" name="place" id="place"   onkeypress="nextField(event.keyCode,nationality)" value="<?php echo (!empty($post['place']))?$post['place']:''?>" autocomplete="off" onKeyUp="ajax_showOptions(this,'getPlace',event)"/> 	 
							</td>
							
							<td id="noborder">							
								
								<?php echo $lang_nationality; ?> : 
							</td>
							<td id="noborder">								
								 <select name="nationality" id="nationality" onkeypress="nextField(event.keyCode,contact_no)">
											<option value=''>------------------------------</option>
											
										<?php for($i=0;$i<count($countries);$i++){ 
																						
													if(!empty($post['nationality']) && $post['nationality']==$countries[$i][1]) { ?>
													
														<option value='<?php echo $countries[$i][1];?>' selected><?php echo $countries[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $countries[$i][1];?>' <?php echo ($countries[$i][1] == "India")?"selected":"";?>><?php echo $countries[$i][1];?></option>
												
										<?php 		} 
												} ?>
										</select> 	 
							</td>
                                                       <td id="noborder">							
								
								<?php echo $lang_mobile_no; ?>  : 
							</td>
							<td id="noborder">
								
								 <input name="mobile_no" id="mobile_no" tabbindex="2"  onkeypress="nextField(event.keyCode,contact_no)" value="<?php echo (!empty($post['mobile_no']))?$post['mobile_no']:''?>" autocomplete="off"/> 
								 
							</td>
						</tr>
						<tr>
							<td id="noborder">							
								
								<?php echo $lang_contact_no; ?>  : 
							</td>
							<td id="noborder">
								
								 <input name="contact_no" id="contact_no" tabbindex="2"  onkeypress="nextField(event.keyCode,email)" value="<?php echo (!empty($post['contact_no']))?$post['contact_no']:''?>" autocomplete="off"/> 
								 
							</td>
						
							<td id="noborder">							
								<?php echo $lang_email; ?> :
							</td>
							<td id="noborder">
								
								 <input name="email" id="email" tabbindex="2"  onkeypress="nextField(event.keyCode,refferal_info)" value="<?php echo (!empty($post['email']))?$post['email']:''?>" autocomplete="off"/> 								 
							</td>
							<td id="noborder">							
								<?php echo $lang_refferal_info; ?> :
							</td>
							<td id="noborder">
								
								 <input name="refferal_info" id="refferal_info" tabbindex="2"  onkeypress="nextField(event.keyCode,department)" value="<?php echo (!empty($post['refferal_info']))?$post['refferal_info']:''?>" autocomplete="off"/> 								 
							</td>
						</tr>
						<tr>
							<td id="noborder">							
								<?php echo $lang_dr." ".$lang_department; ?> :
							</td>
							<td id="noborder">
									<select name="department" id="department" onkeypress="nextField(event.keyCode,doctor)" onChange="processForm();" <?php echo (!empty($post['token']))?'disabled':'';?>>
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($departments);$i++){ 
																						
													if(!empty($post['department']) && $post['department']==$departments[$i][0] ) { ?>
													
														<option value='<?php echo $departments[$i][0];?>' selected><?php echo $departments[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $departments[$i][0];?>'><?php echo $departments[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_doctor; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<select name="doctor" id="doctor" onkeypress="nextField(event.keyCode,inc)"  /> 		
									<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($doctors);$i++){ 
																						
													if(!empty($post['doctor']) && $post['doctor']==$doctors[$i][0]) { ?>
													
														<option value='<?php echo $doctors[$i][0];?>' selected><?php echo $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $doctors[$i][0];?>'><?php echo  $doctors[$i][1].".".$doctors[$i][2]." ".$doctors[$i][3];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_bystander; ?> :
								</td>
								<td>
									<input type="checkbox" id="bystander_status"  name="bystander_status" value="1" <?php echo ($post['bystander_status']==1 ? 'checked' : '');?> style="height:20px;width: 20px;">
								</td>	
							
						</tr>
						
						
						
				</table>
				</div>
			  </div>
				
		
		
<?php if($action == "SAVE") { ?>

               	<div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_select." ".$lang_room;?></h3>
                    </div>		
				
				<table  class="table table-striped">
		
					<tr>
						<td id="noborder">							
								<?php echo $lang_room_no; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<select name="room" id="room">
				
										<option value="">-----------</option>
					
									<?php if(!empty($roomInfo)){
				
											for($i=0;$i<count($roomInfo);$i++) { ?>
						
						
												<option  value="<?php echo $roomInfo[$i][0];?>"><?php echo $roomInfo[$i][1];?></option>
							
											<?php } ?>
				          
				
				
									<?php } ?>
					
					
								</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_bed_no; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								
								<select name="bed_no" id="bed_no">
								
									
									
								</select>
							</td>
							
							<td id="noborder">							
								<?php echo $lang_rent; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<input type="text" name="rent" id="rent" readonly size="8"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_nursing_charges; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<input type="text" name="ncharge" id="ncharge" readonly size="8"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_bystander_charge; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<input type="text" name="bcharge" id="bcharge" readonly size="8"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_maintenance; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<input type="text" name="mcharge" id="mcharge" readonly size="8"/>
							</td>
						</tr>
					</table>
			</div>
		
		<?php }else{ ?>
		
		  <div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_room;?></h3>
                    </div>		
				
				
			<table  class="table table-striped">
					

                                 <?php 

                                   $cur_ad_date=='';
                                   $roomhist=$this->popArr['roomhist'];

                                       if(!empty($roomhist)){

                                               for($i=0;$i<count($roomhist);$i++) { 
                                               	// var_dump($roomhist);
                                               ?>

                                               <tr>
						<td id="noborder">							
								<?php echo $lang_room_no; ?> &nbsp;:<?php echo $roomhist[$i][7];?>
								
					     </td>
						 <td id="noborder">							
								<?php echo $lang_bed_no; ?> &nbsp;:<?php echo $roomhist[$i][8];?>
                                                                
						</td>
						<td id="noborder">							
								<?php echo $lang_rent; ?>&nbsp; :<?php echo $roomhist[$i][6];?>
                                                                
						</td>
						<td id="noborder">							
								<?php echo $lang_nursing_charges; ?>&nbsp; :<?php echo $roomhist[$i][9];?>
                                                                
						</td>
						<td id="noborder">							
								<?php echo $lang_bystander_charge; ?>&nbsp; :<?php echo $roomhist[$i][11];?>
                                                                
						</td>
						<td id="noborder">							
								<?php echo $lang_maintenance; ?>&nbsp; :<?php echo $roomhist[$i][10];?>
                                                                
						</td>
                                                <td id="noborder">							
								<?php echo $lang_from_date; ?>&nbsp; :<?php echo date("d-m-Y",strtotime($roomhist[$i][2]));?>
                                                                
						</td>
                                                <td id="noborder">							
								<?php echo $lang_to_date; ?>&nbsp; :<?php echo date("d-m-Y",strtotime($roomhist[$i][3]));?>
                                                                
						</td>
					</tr>
                                        
      

                                <?php       

                                                 if($i==(count($roomhist)-1)){

                                                         $cur_ad_date=$roomhist[$i][3];

                                                  }

                                           } 
                                     }
                               ?>
                                        <tr style="font-weight:bold;">
						<td id="noborder">							
								<?php echo $lang_room_no; ?> &nbsp;:<?php echo $post['room_no'];?>
								<input type="hidden" name="old_room" value="<?php echo $post['room_no'];?>" />
                                                                <input type="hidden" name="room_id" value="<?php echo $post['room_id'];?>" />
					     </td>
						 <td id="noborder">							
								<?php echo $lang_bed_no; ?> &nbsp;:<?php echo $post['bed_no'];?>
                                                                 <input type="hidden" name="bed_id" value="<?php echo $post['bed_id'];?>" />
						</td>
						<td id="noborder">							
								<?php echo $lang_rent; ?>&nbsp; :<?php echo $post['rent'];?>
                                                                <input type="hidden" name="current_rent" value="<?php echo $post['rent'];?>" />
						</td>
						<td id="noborder">							
								<?php echo $lang_nursing_charges; ?>&nbsp; :<?php echo $post['ncharge'];?>
                                                                <input type="hidden" name="current_ncharge" value="<?php echo $post['ncharge'];?>" />
						</td>
						<td id="noborder">							
								<?php echo $lang_bystander_charge; ?>&nbsp; :<?php echo $post['bcharge'];?>
                                                                <input type="hidden" name="current_bcharge" value="<?php echo $post['bcharge'];?>" />
						</td>
						<td id="noborder">							
								<?php echo $lang_maintenance; ?>&nbsp; :<?php echo $post['mcharge'];?>
                                                                <input type="hidden" name="current_mcharge" value="<?php echo $post['mcharge'];?>" />
						</td>
						
                                                <td id="noborder">							
								<?php echo $lang_from_date; ?>&nbsp; :<?php echo (!empty($cur_ad_date))?date("d-m-Y",strtotime($cur_ad_date)):date("d-m-Y",strtotime($post['admission_date']));?>
                                                                
						</td>
					</tr>
			</table>
                      
		</div>
                  <div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_room_transfer;?></h3>
                    </div>		
				
				
			<table  class="table table-striped">
				
					<tr>
						<td id="noborder">							
								<?php echo $lang_room_no; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<select name="room" id="room">
				
										<option value="">-----------</option>
					
									<?php if(!empty($roomInfo)){
				
											for($i=0;$i<count($roomInfo);$i++) { ?>
						
						
												<option value="<?php echo $roomInfo[$i][0];?>"><?php echo $roomInfo[$i][1];?></option>
							
											<?php } ?>
				          
				
				
									<?php } ?>
					
					
								</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_bed_no; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								
								<select name="bed_no" id="bed_no">
								
									
									
								</select>
							</td>
							
							<td id="noborder">							
								<?php echo $lang_rent; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
								<input type="text" name="rent" id="rent" readonly />
							</td>
							<td id="noborder">
								<input type="text" name="ncharge" id="ncharge" readonly />
							</td>
							<td id="noborder">
								<input type="text" name="bcharge" id="bcharge" readonly />
							</td>
							<td id="noborder">
								<input type="text" name="mcharge" id="mcharge" readonly />
							</td>
						</tr>
					</table>
                </div>
		
		<?php } ?>
					
				<!--..................... SELECT INSURANCE DETAILS ......................-->	
				 <div class="box box-info">
                    <div class="box-header with-border">
                       <h3 class="box-title"><?php echo $lang_insurance_company." ".$lang_information;?></h3>
                    </div>		
				
				
			<table  class="table table-striped">
			
					<tr>
						<td id="noborder">							
								<?php echo $lang_insurance_company; ?> <span id='requiredfield'>*</span>:
							</td>
							<td id="noborder">
									<select name="insurance_company" id="insurance_company" onkeypress="nextField(event.keyCode,policy_no)" onChange="processForm();">
											<option value=''>------------------------------</option>
											
											<?php for($i=0;$i<count($inc_company);$i++){ 
																						
													if(!empty($post['insurance_company']) && $post['insurance_company']==$inc_company[$i][0]) { ?>
													
														<option value='<?php echo $inc_company[$i][0];?>' selected><?php echo $inc_company[$i][1];?></option>
										<?php   	}else {?>
										
														<option value='<?php echo $inc_company[$i][0];?>'><?php echo  $inc_company[$i][1];?></option>
												
										<?php 		} 
												} ?>
									</select>
							</td>
							<td id="noborder">							
								<?php echo $lang_policy_no; ?> :
							</td>
							<td id="noborder">
								<input name="policy_no" id="policy_no" tabbindex="2"  onkeypress="nextField(event.keyCode,claim)" value="<?php echo (!empty($post['policy_no']))?$post['policy_no']:''?>" autocomplete="off"/> 		</td>
								<td id="noborder">							
								<?php echo $lang_claim_no; ?> :
							</td>
							<td id="noborder">
								<input name="claim" id="claim" tabbindex="2"  onkeypress="nextField(event.keyCode,company_name)" value="<?php echo (!empty($post['claim']))?$post['claim']:''?>" autocomplete="off"/> 		</td>	
						
					</tr>
					<tr>
						<td id="noborder">							
								<?php echo $lang_company_name; ?> :
							</td>
							<td id="noborder">
									<input name="company_name" id="company_name" tabbindex="2"  onkeypress="nextField(event.keyCode,company_id)" value="<?php echo (!empty($post['company_name']))?$post['company_name']:''?>" autocomplete="off"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_company_id; ?> :
							</td>
							<td id="noborder">
								<input name="company_id" id="company_id" tabbindex="2"  onkeypress="nextField(event.keyCode,relation)" value="<?php echo (!empty($post['company_id']))?$post['company_id']:''?>" autocomplete="off"/> 		</td>
								<td id="noborder">							
								<?php echo $lang_relation; ?> :
							</td>
							<td id="noborder">
								<input name="relation" id="relation" tabbindex="2"  onkeypress="nextField(event.keyCode,date_issue)" value="<?php echo (!empty($post['relation']))?$post['relation']:''?>" autocomplete="off"/> 		</td>	
						
					</tr>
					<tr>
						<td id="noborder">							
								<?php echo $lang_date_issue; ?> :
							</td>
							<td id="noborder">
									<input name="date_issue" id="date_issue" tabbindex="2"  onkeypress="nextField(event.keyCode,date_expiry)" value="<?php echo (!empty($post['date_issue']))?$post['date_issue']:''?>" autocomplete="off" readonly="true" class="DatePicker"/>
							</td>
							<td id="noborder">							
								<?php echo $lang_date_expiry; ?> :
							</td>
							<td id="noborder">
									<input name="date_expiry" id="date_expiry" tabbindex="2"  onkeypress="nextField(event.keyCode,remarks)" value="<?php echo (!empty($post['date_expiry']))?$post['date_expiry']:''?>" autocomplete="off" readonly="true" class="DatePicker"/>
							</td>
					</tr>
				</table>	
			</fieldset>
	
				
		
	
	
	
			<?php echo $lang_remarks; ?> :
			<input name="remarks" id="remarks" tabbindex="2"  onkeypress="nextField(event.keyCode,Register)" value="<?php echo (!empty($post['remarks']))?$post['remarks']:''?>" autocomplete="off"/>
			
		<?php if(!isset($this->popArr['message1'])){ 
					if($action =="SAVE"){
		?>
			 	<input id="button1" type="button" name="admit"  class="btn btn-success" value="Admit" onclick="return submitForm()"/>
		<?php  }else{ ?>
				<input id="button1" type="button" name="admit" class="btn btn-success" value="Update" onclick="return submitForm()"/>
				<!--<input id="button1" type="button" name="trasfer" class="trasfer" value="Transfer Room" onclick="return submitForm()"/>-->
				<!-- <input id="button1" type="button" name="discharge" class="btn btn-info" value="Discharge" onclick="return submitForm()"/> -->
		<?php  } ?>
		<?php }else { ?>
		
				<br /><font color="#FF0000"><?php echo $this->popArr['message1']; ?></font>
		
		<?php } ?>
		</div>			
			</section>
			</div>
  <input name="paction" id="paction" type="hidden" value="<?php echo $action;?>" /> 
   
 
   <input name="id" id="id" type="hidden" value="<?php echo (!empty($post['id']))?$post['id']:''?>" />
     
    <input type="hidden" name="member_id" id="member_id" value="<?php echo (!empty($post['member_id']))?$post['member_id']:''?>" >
<input type="hidden" name="member_patient_id" id="member_patient_id" value="<?php echo (!empty($post['member_patient_id']))?$post['member_patient_id']:''?>" > 
<input type="hidden" name="observation" id="observation" value="<?php echo (!empty($observation))?$observation:'NO'?>" > 
  <input name="card_expiry" id="card_expiry" type="hidden" value="<?php echo (!empty($post['card_expiry']))?$post['card_expiry']:''?>" />  
    
</form>
</body>
	</html>
	
